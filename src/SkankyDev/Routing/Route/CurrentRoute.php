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
use SkankyDev\Utilities\Traits\StringFacility;

class CurrentRoute
{

	use StringFacility;

	private $controller;
	private $action;
	private $link;
	
	function __construct(string $uri ,Route $route = null){
		$this->uri = $uri;
		if($route){
			$this->initFromRoute($route,$uri);
		}else{
			$this->initFromUri($uri);
		}
	}

	public function initFromRoute($route,$uri){
		$this->link = $route->getLink();
		if(isset($this->link['params'])){

			$exeptedParams = $this->link['params'];
			unset($this->link['params']);
			$shema = $route->getShema();
			$shema = trim($shema,'/');
			$shema = explode('/',$shema);
			$uri = trim($uri,'/');
			$uri = explode('/',$uri);
			$params = [];
			foreach ($shema as $key => $value) {
				if(substr($value,0,1)===":"){
					$k = substr($value,1);
					$params[$k] = $uri[$key];
				}
			}
			$this->link['params'] = $params;
		}

		$this->setControllerAction();
	}

	public function initFromUri($uri){

		$uri = trim($uri,'/');
		$tmp = explode('/', $uri);
		$modules = Config::getModuleList();
		$namespace = $this->toCap($tmp[0]);
		if(in_array($namespace, $modules)){
			$this->link['namespace'] = $namespace;
			array_shift($tmp);
		}else{
			$this->link['namespace']  = Config::getDefaultNamespace();
		}
		$this->link['controller'] = $this->toCap($tmp[0]);
		$this->link['action']     = isset($tmp[1]) ? lcfirst($this->toCap(trim($tmp[1],'_'))) : Config::getDefaultAction();

		if(isset($tmp[2])&&!empty($tmp[2])){
			$this->link['params'] = array_slice($tmp,2);
		}

		$this->setControllerAction();

	}

	private function setControllerAction(){
		$this->controller = $this->link['namespace'].'\\Controller\\'.$this->link['controller'].'Controller';
		$this->action = $this->link['action'];
	}

	public function getController(){
		return $this->controller;
	}

	public function getAction(){
		return $this->action;
	}

	public function getParams(){
		return isset($this->link['params'])?$this->link['params']:[];
	}

	public function getLink(){
		return $this->link;
	}

	public function getNamespace(){
		return $this->link['namespace'];
	}
}