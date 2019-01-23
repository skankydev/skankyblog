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

namespace App\Controller;

use SkankyDev\Controller\MasterController;

class PaymentController extends MasterController {

	public $tools = [
		'Flash','Mail','Paypal'
	];
	
	public function index(){

	}

	protected function paypal($commande_id){
		$this->Commande = $this->_loadModel('Commande');
		$commande = $this->Commande->findById($commande_id);
		$product = $commande->product;
		$shipping = (array)array_pop($product);
		$this->Paypal->setPayer('paypal');
		$this->Paypal->addProduct($product);
		$this->Paypal->setShipping($shipping,$commande->prixTotal);
		$this->Paypal->setTotal($commande->prixTotal);
		$this->Paypal->initTransaction($commande);
		$this->Paypal->initPayment();
		$this->Paypal->authoriz();
		
	}

	protected function retour($result){
		if($result=='success'){
			if(isset($_GET['paymentId'],$_GET['token'],$_GET['PayerID'])){
				$result = $this->Paypal->execute($_GET);
				$this->Commande = $this->_loadModel('Commande');
				$commande = $this->Commande->findOne(['num'=>(int)$result['num']]);
				$commande->payment = $result;
				$this->Commande->save($commande);
				$this->Flash->set(_('Le paiement a bien etait enregistrée'),['class' => 'success']);
				$this->request->redirect(['controller'=>'commande','action'=>'view','params'=>['num'=>$result['num']]]);
			}else{
				$this->Flash->set(_('une erreur est survenue lors du paiement'),['class' => 'error']);
			}
		}else{
			$this->Flash->set(_('une erreur est survenue lors du paiement'),['class' => 'error']);
		}
		$this->request->redirect(['controller'=>'commande','action'=>'index']);

	}

}
