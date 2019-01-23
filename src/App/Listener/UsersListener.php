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

namespace App\Listener;

use SkankyDev\Controller\Tools\FlashMessagesTool;
use SkankyDev\Listener\MasterListener;
use SkankyDev\Model\MasterModel;
use SkankyDev\Utilities\Token;
use SkankyDev\Auth;
use SkankyDev\Factory;

class UsersListener extends MasterListener {
	
	public function __construct(){

	}

	public function infoEvent(){
		return [
			'users.login'=>'getPermission',
			'auth.firstStep' => 'cookieLogin',
		];
	}

	public function getPermission($subject){
		$auth = Auth::getInstance();
		$model = MasterModel::load('App\Model\PermissionModel',true);
		$user = $auth->getAuth();
		$perm = $model->findOne(['name'=>$user->role]);
		unset($perm->_id);
		$auth->setPermission($perm);
	}

	public function cookieLogin($subject){
		$auth = Auth::getInstance();
		$data = $auth->getCookieToken();
		if($data){
			$model = MasterModel::load('App\Model\UserModel',true);
			$user = $model->findOne(['email'=>$data['email'],'cookie'=>$data['token']]);
			if($user){
				$token = new Token();
				$cookiToken = $token->value;
				$model->updateLogin($user,$cookiToken);
				$user->_id = $user->_id->__toString();//MongoDB\BSON\ObjectID fatal error session
				$auth->setAuth($user);
				$auth->setCookieTokent($user->email,$cookiToken);
				$this->getPermission($subject);
			}
		}
	}
}
