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

use SkankyDev\EventManager;


class Factory {

	static function load($className,$params = [],$thr = true){
		try {
			if(!class_exists($className)){
				self::loadFile($className,$thr);
			}
			$class = new \ReflectionClass($className);
			return $class->newInstanceArgs($params);			
		} catch (\Exception $e) {
			if($thr){
				throw $e;
			}else{
				return false;
			}
		}
	}

	static function loadFile($className,$thr = true){
		$folder = explode('\\',$className);
		$path =APP_FOLDER.DS.'src';
		foreach ($folder as $value) {
			$path .= DS.$value;
		}
		$path .= '.php';
		if(!file_exists($path)){
			if($thr){
				throw new \Exception("the file {$path} does not exist");
			}else{
				return false;
			}
		}
		if(EventManager::getInstance()){
			EventManager::getInstance()->event('factory.load',null,$path);
		}
		include_once $path;
	}
	
}
