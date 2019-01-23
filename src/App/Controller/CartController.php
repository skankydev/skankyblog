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
use SkankyDev\Utilities\Session;

class CartController extends MasterController {
	
	public function index(){
		$cart = Session::get('cart');
		$this->view->set(['cart'=>$cart]);
	}

	public function add($ref='',$quantity = 0){
		$this->view->displayLayout = false;
		$productModel=$this->_loadModel('Product');
		$product = $productModel->findOne(['ref'=>$ref]);
		$cart = Session::get('cart');
		$toSession['ref']=$product->ref;
		$toSession['name']=$product->name;
		$toSession['prix']=$product->prix;
		$toSession['quantity']=$quantity;
		$toSession['total']=$quantity*$product->prix;
		$cart[] = $toSession;
		Session::set('cart',$cart);
		$this->view->set(['cart'=>$cart]);
	}

	public function delete($key = 0, $redirect = false){
		if($redirect){
			$key-=1;
		}
		$this->view->displayLayout = false;
		$cart = Session::get('cart');
		array_splice($cart,(int)$key,1);
		Session::set('cart',$cart);
		if($redirect){
			$this->request->redirect(['action'=>'index']);
		}
		$this->view->set(['cart'=>$cart]);
	}

	public function edit($key,$quantity){
		$key-=1;
		$this->view->displayLayout = false;
		$cart = Session::get('cart');
		debug($quantity);
		echo "\n";
		debug($key);
		echo "\n";
		debug($cart[$key]);
		$cart[$key]['quantity'] = (int)$quantity;
		$cart[$key]['total'] = (int)$quantity * (float)$cart[$key]['prix'];
		debug($cart[$key]);
		Session::set('cart',$cart);
	}
}
