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

namespace SkankyDev\view\FormElement;

class MasterElement {
	
	public function __construct(&$form , $option = []){
		$this->form = $form;
	}
	
	function input($name,$attr = [],$value = ''){}

}
