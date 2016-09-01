<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */

namespace App\View\Helper;

use SkankyDev\View\Helper\MasterHelper;

/**
 * ca viendra un jour
 * promi
 * ca viendra bientot
 */
class WysiwygHelper extends MasterHelper {
	
	private $default;

	function __construct($option = array()){
		$this->option = $option;
	}

	function __invock($name,$attr){
		return 'coucou wysiwyg';
	}
}