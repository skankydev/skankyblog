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
use SkankyDev\Utilities\Token;
use SkankyDev\Auth;

class TestController extends MasterController {
	
	public function index(){
		Session::destroy();
		//$token = new Token();
		//$Auth = Auth::getInstance();
		//debug($token);'skankydev.historique'
		//debug(Session::get('skankydev.historique'));
		//debug(Session::get('test.token'));
		//debug($Auth->cookie->get('user.token'));
		//$Auth->cookie->set('user.token',$token->value);
		//$data = $Auth->cookie->get();
		//debug($data);
		//debug($_COOKIE);
	}

}
