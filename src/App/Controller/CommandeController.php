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
use SkankyDev\Config\Config;
use SkankyDev\Auth;

class CommandeController extends MasterController {
	
	public $tools = [
		'Flash','Mail'
	];

	protected function index($page = 1,$field = 'created',$order = 1){
		$user = Auth::getAuth();
		$option = [
			'limit'=>25,
			'query'=>['clientMail'=>$user->email],
			'page'=>(int)$page,
			'sort'=>[],
		];
		$option['sort'][$field] = (int)$order;
		$commandes = $this->Commande->paginate($option);

		$this->view->set(['commandes' => $commandes]);

	}

	protected function create(){
		$this->Profil = $this->_loadModel('profil');
		$this->Transport = $this->_loadModel('transport');
		$user = Auth::getAuth();
		$profil = $this->Profil->findOne(['user_email'=>$user->email]);
		if(!$profil){
			$this->Flash->set('Merci de completer votre profil',['class' => 'warning']);
			$this->request->redirect(['controller'=>'profil','action'=>'edit']);
		}
		$cart = Session::get('cart');
		if($this->request->isPost()){
			$data = $this->request->getData();
			$transport = $this->Transport->findOne(['ref'=>$data->fraisPort]);
			$commande = $this->Commande->create($cart,$profil,$user,$transport,$data);
			if($commande){
				$this->Mail->creatMail($user->email,'votre commande','commande.valide',['commande'=>$commande,'titre'=>_('votre commande')]);
				$this->Mail->sendMail();
				$mail = Config::get('adminMail');
				$this->Mail->creatMail($mail,'une nouvelle commande','commande.valide',['commande'=>$commande,'titre'=>_('nouvelle commande')]);
				$this->Mail->sendMail();
				$this->Flash->set('votre commande',['class' => 'success']);
				Session::delete('cart');
				$this->request->redirect(['action'=>'view','params'=>['num'=>$commande->num]]);
			}else{
				$this->Flash->set('une erreur est survenue',['class' => 'warning']);
			}
		}
		$transport = $this->Transport->find();
		$this->view->set(['cart'=>$cart,'profil'=>$profil,'user'=>$user,'transport'=>$transport]);

	}

	protected function view($num){
		$user = Auth::getAuth();
		$commande = $this->Commande->findOne(['clientMail'=>$user->email,'num'=>(int)$num]);
		$this->view->set(['commande'=>$commande]);

	}

	private function list(){

	}



}
