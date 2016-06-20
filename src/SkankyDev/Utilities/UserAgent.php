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


	function __construct(){

		$this->agent = $_SERVER['HTTP_USER_AGENT'];

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
	}
}