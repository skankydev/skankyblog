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
namespace SkankyDev\Utilities;

/**
* UserAgent
*
* aide à déterminer quel est le client 
* 
* http://www.useragentstring.com
*/

class UserAgent {
	
	public $os      = 'unknow';
	public $browser = 'unknow';
	public $mobile  = false;

	private static $_instance = null;

	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new UserAgent();
		}
		return self::$_instance;
	}

	function __construct(){
		/**
		 * get_browser() essaie de déterminer les capacités du navigateur client en lisant les informations dans le fichier browscap.ini
		 * le fichier est a dl: https://browscap.org/
		 * prendre le lite sinon ca rame et ca donne des info inutile
		 * activer dans le php.ini
		 */

		//$this->info = get_browser($_SERVER['HTTP_USER_AGENT']);
		$this->agent = $_SERVER['HTTP_USER_AGENT'];
		//debug($this->agent);
		//debug($this->info);
		if(preg_match('/iphone/i', $this->agent) || preg_match('/ipad/i',$this->agent) || preg_match('/ipod/i',$this->agent)){
			$this->os = 'iOS';
			$this->mobile = true;
		}else if(preg_match('/android/i',$this->agent)){
			$this->os = 'Android';
			$this->mobile = true;
		}else if(preg_match('/Mac OS/i',$this->agent)){
			$this->os = 'MacOSX';
			$this->mobile = false;
		}else if(preg_match('/Windows/i',$this->agent)){
			$this->os = 'Windows';
			$this->mobile = false;
		}else if(preg_match('/Ubuntu/i',$this->agent)){
			$this->os = 'Ubuntu';
			$this->mobile = false;
		}else if(preg_match('/Linux/i',$this->agent)){
			$this->os = 'Linux';
			$this->mobile = false;
		}

		if(preg_match('/Safari/i', $this->agent)&&!preg_match('/Chrome/i', $this->agent)){
			$this->browser = 'Safari';
		}else if (preg_match('/Chrome/i', $this->agent)) {
			$this->browser = 'Chrome';
		}else if (preg_match('/Firefox/i', $this->agent)) {
			$this->browser = 'Firefox';
		}else if (preg_match('/Opera/i', $this->agent)) {
			$this->browser = 'Opera';
		}

		//debug($this);
	}

	public function getDevice(){
		/*if($this->info->ismobiledevice){
			return 'Mobile';
		}
		if($this->info->istablet){
			return 'Tablet';
		}*/
		return $this->mobile?'Mobile':'Desktop';
	}
}
