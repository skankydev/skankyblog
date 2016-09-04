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

use SkankyDev\Listener\MasterListener;
use SkankyDev\Model\MasterModel;
use SkankyDev\Utilities\Token;
use SkankyDev\Auth;

class UsersListener extends MasterListener {
	
	public function __construct(){

	}

	public function infoEvent(){
		return [
			'users.login'=>'trucdeouf',
			'auth.firstStep' => 'cookieLogin',
		];
	}

	public function trucdeouf($subject){
		debug('trucdeouf');
	}

	public function cookieLogin(){
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
			}
		}
	}
}
