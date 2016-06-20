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
namespace SkankyDev\I18n;

use SkankyDev\Config\Config;
use Locale;
use Collator;

class Localization {

	static $conf;

	public static function initGetText($location){

		// ca va surment changer
		// TODO se code est a revoir
		self::$conf = Config::get('location.'.$location);
		//Locale::getRegion
		// je suis sous window ca bug. marchera plus tard
		setlocale(LC_ALL, self::$conf['langue']);
		//putenv("LANGUAGE=english");
		putenv('LANG='.self::$conf['langue']);
		putenv('LC_ALL='.self::$conf['langue']);
		//setlocale(LC_MESSAGES, $conf['langue']);
		
		$domain = self::$conf['domaine'];
		bindtextdomain($domain, APP_FOLDER.DS."locale"); 
		textdomain($domain);
	}

	public static function getLang(){
		return self::$conf['langue'];
	}
}
