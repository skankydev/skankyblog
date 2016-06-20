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

namespace SkankyDev\Config;


include_once APP_FOLDER.DS."SkankyDev".DS."Utilities".DS."Debug.php"; 
include_once APP_FOLDER.DS."SkankyDev".DS."Config".DS."Config.php"; 

/**
 * inutilisé :(
 */
class Autoloader {

	static $config;

	static function register(){
		self::$config = Config::get('autoloader');
		debug(__CLASS__);
		spl_autoload_register(array(__CLASS__,'autoload'));
	}

	static function autoload($class){
		$folder = explode('\\',$class);
		$path =APP_FOLDER;
		foreach ($folder as $value) {
			if(array_key_exists($value, self::$config)){
				$path .= DS.self::$config[$value];
			}
			$path .= DS.$value;
		}
		$path .= '.php';
		/*if(!file_exists($path)){
			throw new \Exception("the class {$class} does not exist [$path]");
		}*/
		include_once $path;
	}
}
