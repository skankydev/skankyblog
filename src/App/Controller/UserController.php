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
use SkankyDev\EventManager;
use SkankyDev\Auth;


class UserController extends MasterController {

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

	public function add(){
		if($this->request->isPost()){
			$data = $this->request->data;
			$user = $this->User->createDocument($data);
			if($data->password === $data->confirme){
				if($this->User->isValid($user)){
					$user->password = password_hash($data->password, PASSWORD_BCRYPT);
					if($this->User->save($user)){
						$this->Flash->set('ca marche',['class' => 'success']);
						//un petit send mail
						$this->request->redirect('/');
					}else{
						$this->Flash->set('ca marche pas',['class' => 'error']);
						unset($user->password);
						$this->request->data = $user;
					}
				}else{
					$this->Flash->set('pas valid',['class' => 'warning']);
					unset($user->password);
					$this->request->data = $user;
				}				
			}else{
				$data->messageValidate['confirme'] = 'les mdp c pas les meme >_< !';
				unset($data->password);
				unset($data->confirme);
				$this->request->data = $data;
			}

		}
	}

	public function login(){
		if($this->request->isPost()){
			$data = $this->request->data;
			$user = $this->User->findOne(['username'=>$data->username]);
			if(!empty($user)){
				if(password_verify($data->password,$user->password)){
					$user->_id = $user->_id->__toString();//MongoDB\BSON\ObjectID fatal error session
					$link = Auth::getInstance()->setAuth($user);
					EventManager::getInstance()->event('users.login',$this);
					$this->Flash->set('success',['class' => 'success']);
					$this->request->redirect($link);
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
