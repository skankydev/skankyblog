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
use SkankyDev\EventManager;
use SkankyDev\Config\Config;
use SkankyDev\Utilities\Session;
use SkankyDev\Utilities\Traits\StringFacility;

class MasterView {

	use StringFacility;

	public $script = '';

	public $data = [];
	public $layout = 'default';
	public $helpers = [];

	function __construct(){
		EventManager::getInstance()->event('view.construct',$this);
		$this->request = Request::getInstance();
	}

	/**
	 * render the view
	 */
	public function render(){
		EventManager::getInstance()->event('view.render.before',$this);
		$this->loadHelper();
		extract($this->data);
		ob_start();
		require($this->viewPath());
		$this->content = ob_get_clean();
		
		if($this->layout){
			require ($this->layoutPath());
		}else{
			echo $this->content;
		}
	}

	/**
	 * render a element of view 
	 * @param string $element element name
	 * @param  array  $option  variable for view
	 * @return view element just say echo
	 */
	public function element($element,$option = []){
		$fileName = Config::elementDir().DS.$element.'.php';
		extract($option);
		ob_start();
		require($fileName);
		return ob_get_clean();
	}


	public function viewPath(){
		$viewFolder = str_replace('Controller','',$this->request->controller);
		$viewFolder = $this->toDash($viewFolder);
		$action = $this->toDash($this->request->action);
		$viewPath = Config::viewDir().DS.$viewFolder.DS.$action.'.php';
		if(!file_exists($viewPath)){
			throw new \Exception("the view file : {$viewPath} does not exist", 601);
		}
		return  $viewPath;
	}

	public function layoutPath(){
		$layoutPath = Config::layoutDir().DS.$this->layout.'.php';
		if(!file_exists($layoutPath)){
			throw new \Exception("the layout file : {$layoutPath} does not exist", 601);
		}
		return $layoutPath;
	}

	/**
	 * create the path/to/folder for diferante view
	 * @return void 
	 */
	public function makePath(){
		$this->layoutPath = Config::layoutDir().DS.$this->layout.'.php';
		if(!file_exists($this->layoutPath)){
			throw new \Exception("the layout file : {$this->layoutPath} does not exist", 601);
		}
		
		$viewFolder = str_replace('Controller','',$this->request->controller);
		$viewFolder = $this->toDash($viewFolder);
		$action = $this->toDash($this->request->action);
		$this->viewPath = Config::viewDir().DS.$viewFolder.DS.$action.'.php';
		if(!file_exists($this->viewPath)){
			throw new \Exception("the view file : {$this->viewPath} does not exist", 601);
		}
	}


	/**
	 * pour afficher un element crée avant layout (la view du controller pour le momant) mais c pas fini 
	 * @param  string $name the name
	 * @return  view element just say echo
	 */
	public function fetch($var){
		echo $this->{$var};
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
	
	public function loadHelper(){
		$def = Config::getHelper();
		foreach ($this->helpers as $helper=> $params) {
			if(is_array($params)){
				$className = $def[$helper];
				$this->{$helper} = Factory::load($className,$params);
			}else{
				$className = $def[$params];
				$this->{$params} = Factory::load($className);
			}
		}
	}


}
