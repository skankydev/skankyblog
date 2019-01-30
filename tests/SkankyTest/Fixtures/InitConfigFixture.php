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

namespace SkankyTest\Fixtures;

use SkankyDev\Config\Config;

if ( !defined('DS') ){
	define('DS', DIRECTORY_SEPARATOR);
}
/*
if ( !defined('APP_FOLDER') ){
	define('APP_FOLDER', dirname(dirname(dirname(__DIR__))));
}

if ( !defined('PUBLIC_FOLDER') ){
	define('PUBLIC_FOLDER',APP_FOLDER.DS.'public');
}*/

class InitConfigFixture
{

	static $isInit = false;


	static function init(){
		if(!self::$isInit){
			$baspath = dirname(dirname(__DIR__)).DS.'data';
			//var_dump($baspath);
			Config::initConf($baspath);
			$isInit = true;
		}
	}
	
}