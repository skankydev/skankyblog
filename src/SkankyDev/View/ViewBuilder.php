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

namespace SkankyDev\View;

use SkankyDev\Factory;
use SkankyDev\Utilities\Traits\Singleton;

class ViewBuilder
{
	use Singleton;

	private $data = [];
	private $viewClass= 'SkankyDev\View\HtmlView';
	private $helpers=[];

	public function __construct(){

	}

	/**
	 * set variable for view 
	 * @param string|array $key   the name or combo name => value
	 * @param mixed $valeur the value
	 */
	public function set($key,$valeur=null){
		if(is_array($key)){
			$this->data += $key;
		}else{
			$this->data[$key] = $valeur;
		}
	}

	public function addHelpers($helpers,$params = []){
		if(is_array($helpers)){
			foreach ($helpers as $key => $value) {
				if(is_array($value)){
					$this->helpers[$key] = $value;
				}else{
					$this->helpers[] = $value;
				}
			}
		}else{
			$key = count($this->helpers);
			$this->helpers[$key] = $helpers;
		}
	}

	public function render(){
		$this->view = Factory::load($this->viewClass);
		if( isset($this->helpers) && !empty($this->helpers)){
			$this->view->addHelpers($this->helpers);
		}
		$this->view->set($this->data);
		$this->view->render();
	}

	public function getData(){
		return $this->data;
	}

	public function getHelpers(){
		return $this->helpers;
	}
}