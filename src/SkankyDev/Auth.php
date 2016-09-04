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

namespace SkankyDev;

use SkankyDev\Config\Config;
use SkankyDev\Utilities\Session;
use SkankyDev\Utilities\UserAgent;
use SkankyDev\Utilities\Cookie;
use SkankyDev\Utilities\Historique;

class Auth
{
	private static $_instance = null;

	static $loged = false;

	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new Auth();
		}
		return self::$_instance;
	}
	public static function isAuthentified(){
		if(!is_null(self::$_instance)) {
			return self::$loged;
		}
		return false;
	}

	public static function loadClass(){
		Factory::loadFile(Config::get('Auth.userEntity'));
	}

	function __construct() {
		$auth = Session::get('skankydev.auth');
		if($auth){
			self::$loged = true;
		}
		$this->historique = new Historique();
		$this->userAgent = new UserAgent();
		$this->cookie    = new Cookie('skankydev_auth',Config::get('Auth.cookieTimer'));
		$this->historique->updateHistorique();
		$current = $this->historique->getCurrent();
		$controller = Config::get('Auth.redirectAction.controller');
		if($current['link']['controller']!==$controller){
			Session::delete('skankydev.backlink');
		}
		if(empty($_COOKIE)||($this->historique->pageCount()==1)){
			$this->firstStep();
		}
		EventManager::getInstance()->event('auth.construct',$this);
	}

	function firstStep(){
		EventManager::getInstance()->event('auth.firstStep',$this);
	}
	
	/**
	 * get the request history
	 * @return array histories
	 */
	public function getHistories(){
		return ['histories'=>$this->historique->getHistorique()];
	}

	public function notDirect(){
		$this->historique->notDirect();
	}

	public function setAuth($auth){

		Session::set('skankydev.auth',$auth);
		self::$loged = true;
		$link = Session::get('skankydev.backlink');
		Session::delete('skankydev.backlink');
		return $link['link'];
	}

	public function unsetAuth(){
		$link = $this->historique->comeFrom();
		Session::delete('skankydev.auth');
		self::$loged = false;
		$this->deleteCookieTokent();

		return $link['link'];
	}

	public function getAuth(){
		//incomplete class pas defini la conne
		return Session::get('skankydev.auth');
	}

	public function setBackLink(){
		if(!Session::get('skankydev.backlink')){
			Session::set('skankydev.backlink',$this->historique->comeFrom());
		}
	}

	public function setCookieTokent($email,$token){
		return $this->cookie->set('user',['email'=>$email,'token'=>$token]);
	}
	
	public function getCookieToken(){
		return $this->cookie->get('user');
	}

	public function deleteCookieTokent(){
		return $this->cookie->delete('user');
	}
}