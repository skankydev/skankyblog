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

namespace SkankyDev\Routing\Route;

use SkankyDev\Config\Config;

/**
 * 	
 */
class Route 
{

	/**
     * Valid HTTP methods.
     *
     * @var array
     */
    const VALID_METHODS = ['GET', 'PUT', 'POST', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'];

	private $shema;
	private $link;
	private $rules;
	private $regex = false;


	
	public function __construct($shema,$link,$rules = []){
		$this->shema = $shema;
		$this->link = $link;
		$this->initLink();

		$this->rules = $rules;

	}

	private function initLink(){
		if(!isset($this->link['action'])){
			$this->link['action'] = Config::getDefaultAction();
		}
		if(!isset($this->link['namespace'])){
			$this->link['namespace'] = Config::getDefaultNamespace();	
		}		
	}

	public function getLink(){
		return $this->link;
	}

	public function getShema(){
		return $this->shema;
	}

	public function makeRegex(){
		$tmp = str_replace('/','\/',$this->shema);
		$tmp = preg_replace_callback('/:[a-z]*/',[$this,'pregCallback'],$tmp);
		$this->regex = '/^'.$tmp.'$/';
	}

	public function pregCallback($params){
		$key = $params[0];
		$key = substr($key,1);
		return $this->rules[$key];
	}

	public function getMatcheRules(){
		if(!$this->regex){
			$this->makeRegex();
		}
		return $this->regex;
	}
}