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
namespace SkankyDev\Controller\Tools;

use SkankyDev\Controller\Tools\MasterTool;
use SkankyDev\Utilities\Session;
/**
* 
*/
class FlashMessagesTool extends MasterTool {

	private $default = [
		'tags' => ['div','span'],
		'attr' => ['class'=>'sucsse']
	];

	private $messages;

	public function __construct(){
		$this->messages = Session::get('FlashMessage');
	}

	public function set($message, $attr = []){
		$this->messages = Session::get('FlashMessage');
		$this->messages[] = ['messages' => $message,'attr' => $attr];
		Session::set('FlashMessage',$this->messages);
	}
}