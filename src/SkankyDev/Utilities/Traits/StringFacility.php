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
namespace SkankyDev\Utilities\Traits;


trait StringFacility {

	public function toDash($string){
		$string = preg_replace('/[A-Z]/',"-$0",$string);
		$string = strtolower($string);
		return trim($string,' -');
	}

	public function toCap($string){
		$string = str_replace('-', ' ', $string);
		$string = ucwords($string);
		$string = str_replace(' ', '', $string);
		return trim($string);
	}
}