<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @since         0.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */
namespace App\Controller;

use SkankyDev\Controller\MasterController;
use Skankydev\Utilities\Token;
use SkankyDev\EventManager;
use SkankyDev\Auth;

class UserController extends MasterController {

	public $tools = [
		'Flash','Mail'
	];

	public function index($page = 1){
		$option = [
			'limit'=>5,
			'query'=>[],
			'page'=>(int)$page,
		];
		$users = $this->User->paginate($option);

		$this->view->set(['users' => $users]);
	}

	protected function view($username){
		$this->view->set(['username'=>$username]);
	}
	
	public function signUp(){
		if($this->request->isPost()){
			$data = $this->request->data;
			$user = $this->User->createDocument($data);
			if($data->password === $data->confirme){
				if($this->User->isValid($user)){
					$user->password = password_hash($data->password, PASSWORD_BCRYPT);
					$user->verifToken = new token();
					$user->valid = false;
					if($this->User->save($user)){
						$this->Mail->creatMail($user->email,'activation de votre compte','user.active',['user'=>$user]);
						$this->Mail->sendMail();
						$this->Flash->set('un mail de confirmation vous a été envoyé',['class' => 'success']);
						$this->request->redirect('/');
					}else{
						$this->Flash->set('oupse on a un problème (-_-)',['class' => 'warning']);
						unset($user->password);
						$this->request->data = $user;
					}
				}else{
					$this->Flash->set('oupse on a un problème (-_-)',['class' => 'warning']);
					unset($user->password);
					$this->request->data = $user;
				}				
			}else{
				$data->messageValidate['confirme'] = 'les mdp c\'est pas les meme (>_<) !';
				unset($data->password);
				unset($data->confirme);
				$this->request->data = $data;
			}
		}

	}

	public function active($login,$token){
		$user = $this->User->findOne(['login'=>$login,'valid'=>false]);
		if(!empty($user)){
			if( ($user->verifToken->value === $token) && (time() < ($user->verifToken->time+WEEK) )){
				$user->valid = true;
				$this->User->save($user);
				$this->Flash->set('votre compte a bien etais activer',['class' => 'success']);
				$user->_id = $user->_id->__toString();
				$link = Auth::getInstance()->setAuth($user);
				EventManager::getInstance()->event('users.login',$this);
				$this->request->redirect('/');
			}	
			
		}
		$this->Flash->set('oupse on a un problème (-_-)',['class' => 'warning']);
			
	}

	public function passwordLost(){
		if($this->request->isPost()){
			$data = $this->request->data;
			debug($data);
			$user = $this->User->findOne(['email'=>$data->email,'valid'=>true]);
			if(!empty($user)){
				debug($user);
				//on fait send mail tout ca tout ca 
			}
		}
	}

	public function login(){
		if($this->request->isPost()){
			$data = $this->request->data;
			$user = $this->User->findOne(['login'=>$data->username]);
			if(!empty($user)){
				
				if(!$user->valid){
					$this->Flash->set('votre compte n\'est pas activé',['class' => 'warning']);
					$this->request->redirect('/');
				}
				if(password_verify($data->password,$user->password)){
					$user->_id = $user->_id->__toString();//MongoDB\BSON\ObjectID fatal error session
					
					$link = Auth::getInstance()->setAuth($user);
					EventManager::getInstance()->event('users.login',$this);
					$this->Flash->set('success',['class' => 'success']);
					//$this->request->redirect($link);
				}
			}
			$this->Flash->set('invalide login or password',['class' => 'warning']);
		}
		Auth::getInstance()->setBackLink();
	}

	public function logout(){
		$link = Auth::getInstance()->unsetAuth();
		$this->Flash->set('success',['class' => 'success']);
		$this->request->redirect($link);
	}
}
