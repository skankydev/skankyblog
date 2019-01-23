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
use SkankyDev\Auth;

class ProfilController extends MasterController {
	
	protected function index(){
		$user = Auth::getAuth();
		$profil = $this->Profil->findOne(['user_email'=>$user->email]);
		if(!$profil){
			$this->request->redirect(['action'=>'edit']);
		}
		$this->view->set(['user'=>$user,'profil'=>$profil]);
	}
	protected function edit(){
		$user = Auth::getAuth();
		$profil = $this->Profil->findOne(['user_email'=>$user->email]);
		if(!$profil){
			$profil = $this->Profil->createDocument(new \stdClass);
			$profil->user_email = $user->email;
			$profil->adresse = [];
			unset($this->request->data->_id);
			debug($profil);
		}
		if($this->request->isPost() && ($this->request->data->user_email === $user->email)){
			$adresse = $profil->adresse;
			$profil = $this->Profil->createDocument($this->request->getData());
			$profil->adresse = $adresse;
			if($this->Profil->isValid($profil)){
				if($this->Profil->save($profil)){
					$this->Flash->set('ça marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ça marche pas',['class' => 'error']);
				}
			}else{
				$this->Flash->set('ça marche pas',['class' => 'warning']);
			}
		}
		$this->request->data = $profil;
		$this->view->set(['user'=>$user,'profil'=>$profil]);
	}

	protected function addAdresse(){
		$user = Auth::getAuth();
		//$profil = $this->Profil->findOne(['user_email'=>$user->email]);
		if($this->request->isPost()){
			$adresse = (array)$this->request->getData();
			//TODO: tu voulais du degelace
			foreach ($adresse as $key => $value) {
				$value = trim($value);
				$value = strip_tags($value);
				$value = htmlentities($value);
				$adresse[$key] = $value;
			}
			//TODO: en voila
			if ($this->Profil->addAdresse($user->email,$adresse)) {
				$this->Flash->set('ça marche',['class' => 'success']);
				$this->request->redirect(['action'=>'index']);
			}else{
				$this->Flash->set('ça marche pas',['class' => 'error']);
			}
		}
	}
	protected function editAdresse($key=0){
		$user = Auth::getAuth();
		$profil = $this->Profil->findOne(['user_email'=>$user->email]);
		if($this->request->isPost()){
			$adresse = (array)$this->request->getData();
			//TODO: tu voulais du degelace
			foreach ($adresse as $k => $value) {
				$value = trim($value);
				$value = strip_tags($value);
				$value = htmlentities($value);
				$adresse[$k] = $value;
			}
			$profil->adresse[$key] = $adresse;
			if($this->Profil->save($profil)){
				$this->Flash->set('ça marche',['class' => 'success']);
				$this->request->redirect(['action'=>'index']);
			}else{
				$this->Flash->set('ça marche pas',['class' => 'error']);
			}
		}
		$this->request->data = (object)$profil->adresse[$key];
		$this->view->set(['key'=>$key]);

	}

	protected function deleteAdresse($key=0){
		$user = Auth::getAuth();
		$profil = $this->Profil->findOne(['user_email'=>$user->email]);
		unset($profil->adresse[$key]);
		$i = 0;
		$adresseList = $profil->adresse;
		unset($profil->adresse);
		foreach ($adresseList as $adresse) {
			$profil->adresse[$i] = $adresse;
			$i++;
		}
		$this->Profil->save($profil);
		$this->Flash->set('ça marche',['class' => 'success']);
		$this->request->redirect(['action'=>'index']);
	}

}
