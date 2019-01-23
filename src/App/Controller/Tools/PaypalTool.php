<?php
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright     Copyright (c) SCHENCK Simon
 *
 */

namespace App\Controller\Tools;

use SkankyDev\Controller\Tools\MasterTool;
use SkankyDev\Config\Config;
use SkankyDev\Request;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;
use DateTime;

class PaypalTool extends MasterTool {
	
	public function __construct(){
		$this->request = Request::getInstance();
		$this->conf = Config::get('paypal');
		$this->apiContext = new ApiContext(
			new OAuthTokenCredential($this->conf['ClientId'] ,$this->conf['Secret'])
		);
		$this->urls = new RedirectUrls();
		$success = $this->request->url($this->conf['success-link']);
		$error = $this->request->url($this->conf['error-link']);
		$this->urls->setReturnUrl($success);
		$this->urls->setCancelUrl($error);
	}
	
	public function setPayer($method){
		$this->payer = new Payer();
		$this->payer->setPaymentMethod($method);		
	}

	public function addProduct($product){
		$this->list = new ItemList();
		foreach ($product as $key => $value) {
			$item = new Item();
			$item->setName($value['name']);
			$item->setCurrency($this->conf['Currencies']);
			$item->setQuantity($value['quantity']);
			$item->setPrice($value['prix']);
			$this->list->addItem($item);
		}
	}

	public function setShipping($shipping,$total){
		$this->detail = new Details();
		$this->detail->setShipping($shipping['total']);
		$st = $total-$shipping['total'];
		$this->detail->setSubtotal($st);
	}

	public function setTotal($total){
		$this->amount = new Amount();
		$this->amount->setCurrency($this->conf['Currencies']);
		$this->amount->setTotal($total);
		if(isset($this->detail)){
			$this->amount->setDetails($this->detail);
		}
	}

	public function initTransaction($commande){
		$this->transaction = new Transaction();
		$this->transaction->setAmount($this->amount);
		$this->transaction->setItemList($this->list);
		$text = _('Commande N° ').$commande->num.' '.$commande->clientName;
		$this->transaction->setDescription($text);
		$this->transaction->setInvoiceNumber($commande->num);
	}

	public function initPayment(){
		$this->payment = new Payment();
		$this->payment->setIntent('sale');
		$this->payment->setPayer($this->payer);
		$this->payment->setRedirectUrls($this->urls);
		$this->payment->setTransactions([$this->transaction]);
	}

	public function authoriz(){
		try {
			$this->payment->create($this->apiContext);
			//debug($this->payment->getApprovalLink());die();
			header('Location: '.$this->payment->getApprovalLink());
			exit();
		} catch (PayPalConnectionException $ex) {
			debug($ex->getData()); 
			throw $ex;
		}
	}

	public function execute($info){
		$payment = Payment::get($info['paymentId'],$this->apiContext);
		$execute = new PaymentExecution();
		$execute->setPayerId($info['PayerID']);
		try {
			$result = $payment->execute($execute,$this->apiContext);
			$retour = [];
			$retour['identifiant'] = $result->getId();
			$retour['state'] = $result->getState();
			$transac = $result->getTransactions();
			$transac = $transac[0];
			$retour['num'] = $transac->getInvoiceNumber();
			$amount = $transac->getAmount();
			$retour['total'] = $amount->getTotal();
			$date = DateTime::createFromFormat('Y-m-d\TH:i:s\Z',$result->getCreateTime());
			$retour['create'] = $date;
			$date = DateTime::createFromFormat('Y-m-d\TH:i:s\Z',$result->getUpdateTime());
			$retour['update'] = $date;
			return $retour;
		} catch (\Exception $ex) {
			debug($ex->getData()); 
			throw $ex;
		}
	}
	
}
