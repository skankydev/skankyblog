<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */
namespace App\Controller;

use SkankyDev\Controller\MasterController;
use SkankyDev\Utilities\Token;
use SkankyDev\EventManager;
use SkankyDev\Auth;
use SkankyDev\Config\Config;

class UserController extends MasterController {

	public $tools = [
		'Flash','Mail'
	];


	private function index($page = 1,$field = 'login',$order = 1){
		$option = [
			'limit'=>25,
			'query'=>[],
			'page'=>(int)$page,
			'sort'=>[],
		];
		$option['sort'][$field] = (int)$order;
		$users = $this->User->paginate($option);

		$this->view->set(['users' => $users]);
	}

	private function delete($_id){
		if(!empty($_id)){
			if($this->User->delete(['_id' => $_id])){
				$this->Flash->set('ca marche',['class' => 'success']);
			}else{
				$this->Flash->set('ca marche pas',['class' => 'error']);
			}
		}
		$this->request->redirect(['action'=>'index']);
	}

	private function view($login){
		$user = $this->User->findOne(['login'=>$login]);
		$this->view->set(['user'=>$user]);
	}
	
	private function profil(){
		$user = Auth::getInstance()->getAuth();
		$this->view->set(['user'=>$user]);
	}

	private function changePass(){
		$user = Auth::getInstance()->getAuth();
		if($this->request->isPost()){
			$user = $this->User->findOne(['login'=>$user->login]);
			$data = $this->request->data;
			if(password_verify($data->password,$user->password)){
				if($data->new === $data->confirme){
					$user->password = password_hash($data->new, PASSWORD_BCRYPT);
					if($this->User->save($user)){
						$this->Flash->set('Votre password a bien était changer',['class' => 'success']);
						$this->request->redirect(['controller'=>'user','action'=>'profil']);
					}else{
						$this->Flash->set('oupse on a un problème (-_-)',['class' => 'warning']);
						unset($this->request->data);
					}
				}else{
					$data->messageValidate['confirme'] = 'les mdp c\'est pas les meme (>_<) !';
					unset($data->password);
					unset($data->new);
					unset($data->confirme);
					$this->request->data = $data;
				}
			}else{
				$data->messageValidate['password'] = 'le mdp c\'est pas le bon (>_<) !';
				unset($data->password);
				unset($data->new);
				unset($data->confirme);
				$this->request->data = $data;
			}
		}
	}

	public function signUp(){
		if($this->request->isPost()){
			$data = $this->request->data;
			$user = $this->User->createDocument($data);
			if(isset($data->cgu)){
				if($data->password === $data->confirme){
					if($this->User->isValid($user)){
						$user->password = password_hash($data->password, PASSWORD_BCRYPT);
						$user->verifToken = new token();
						$user->lastLogin = false;
						$user->valid = false;
						$user->role = Config::get('Auth.defaultRole');
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
			}else{
				$data->messageValidate['cgu'] = 'merci d\'accepter les CGU';
				unset($data->password);
				unset($data->confirme);
				$this->request->data = $data;
			}
		}

	}

	public function active($login,$token){
		$user = $this->User->findOne(['login'=>$login,'valid'=>false]);
		if(!empty($user)){
			if( ($user->verifToken) && ($user->verifToken->value === $token) && (time() < ($user->verifToken->time+WEEK)) ){
				$user->valid = true;
				$user->verifToken = false;
				$this->User->save($user);
				$this->Flash->set('votre compte a bien etais activer',['class' => 'success']);

				$this->request->redirect('/');
			}	
		}else{
			throw new \Exception("error user not found", 5102);
		}
	}

	public function passwordLost(){
		if($this->request->isPost()){
			$data = $this->request->data;
			$user = $this->User->findOne(['email'=>$data->email,'valid'=>true]);
			if(!empty($user)){
				$user->verifToken = new token();
				$this->User->save($user);
				$this->Mail->creatMail($user->email,'recuperation de mot de passe','user.lost',['user'=>$user]);
				$this->Mail->sendMail();
				$this->Flash->set('un e-mail avec les instructions vous a été envoyé',['class' => 'success']);
				$this->request->redirect('/');
			}
		}
	}

	public function recoveryPass($login,$token){
		$user = $this->User->findOne(['login'=>$login,'valid'=>true]);
		if(!empty($user)){
			if( !($user->verifToken) || !($user->verifToken->value === $token) || !(time() < ($user->verifToken->time+DAY)) ){
				//token pas valide
				throw new \Exception("error invalide token recoveryPass", 5101);
			}
			if($this->request->isPost()){
				//si data post
				$data = $this->request->data;
				if($data->password === $data->confirme){
					$user->password = password_hash($data->password, PASSWORD_BCRYPT);
					$user->verifToken = false;
					if($this->User->save($user)){
						$this->Flash->set('votre mot de passe a bien etais changer',['class' => 'success']);
						$this->request->redirect('/');
					}else{
						$this->Flash->set('oupse on a un problème (-_-)',['class' => 'warning']);
						unset($user->password);
					}
				}else{
					$data->messageValidate['confirme'] = 'les mdp c\'est pas les meme (>_<) !';
					unset($data->password);
					unset($data->confirme);
					$this->request->data = $data;
				}
			}
			$this->view->set(['user' => $user]);
		}else{
			throw new \Exception("page not found", 404);
		}
	}


	public function login(){
		if($this->request->isPost()){
			$data = $this->request->data;
			$user = $this->User->findOne(['email'=>$data->email]);
			if(!empty($user)){
				if(password_verify($data->password,$user->password)){
					if(!$user->valid){
						$this->Flash->set('votre compte n\'est pas activé',['class' => 'warning']);
						$this->request->redirect('/');
					}
					$cookiToken = '';

					if(isset($data->remember)){
						$token = new token();
						$cookiToken = $token->value;
						Auth::getInstance()->setCookieTokent($user->email,$cookiToken);
					}
					$this->User->updateLogin($user,$cookiToken);
					$user->_id = $user->_id->__toString();//MongoDB\BSON\ObjectID fatal error session
					$link = Auth::getInstance()->setAuth($user);
					EventManager::getInstance()->event('users.login',$this);
					$this->Flash->set('bienvenu '.$user->login.'.',['class' => 'success']);
					$this->request->redirect($link);
				}
			}
			$this->Flash->set('invalide login or password',['class' => 'warning']);
		}
		Auth::getInstance()->setBackLink();
	}

	public function logout(){
		$user = Auth::getInstance()->getAuth();
		$link = Auth::getInstance()->unsetAuth();
		EventManager::getInstance()->event('users.logout',$this);
		$this->Flash->set('À bientôt '.$user->login.'.',['class' => 'success']);
		$this->request->redirect('/');
	}

}
