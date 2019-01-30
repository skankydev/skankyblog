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
namespace SkankyDev;

use Exception;
use SkankyDev\Config\Config;
use SkankyDev\Routing\UrlBuilder;
use SkankyDev\Utilities\Historique;
use SkankyDev\Utilities\Interfaces\PermissionInterface;
use SkankyDev\Utilities\Session;
use SkankyDev\Utilities\Token;
use SkankyDev\Utilities\Traits\ArrayPathable;
use SkankyDev\Utilities\Traits\StringFacility;
use SkankyDev\Utilities\UserAgent;

class Request {

	use ArrayPathable;
	use StringFacility;

	private static $_instance = null;

	public $uri;
	public $host;
	public $sheme;
	public $method;
	public $protocol;
	public $ip;

	public $namespace;
	public $controller;
	public $action;
	public $params = [];
	public $files = [];
	public $data;

	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new Request();  
		}
		return self::$_instance;
	}

	public function __construct(){
		//debug($_SERVER);
		$this->host      = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
		$this->uri       = isset($_SERVER['HTTP_HOST']) ? urldecode($_SERVER['REQUEST_URI']) : null;
		$this->sheme     = isset($_SERVER['REQUEST_SCHEME'])? $_SERVER['REQUEST_SCHEME'] : null;
		$this->method    = isset($_SERVER['REQUEST_METHOD'])?$_SERVER['REQUEST_METHOD']:null;
		$this->protocol  = isset($_SERVER['SERVER_PROTOCOL'])?$_SERVER['SERVER_PROTOCOL']:null;
		$this->ip        = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:null;
		$this->referer   = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
		//EventManager::getInstance()->event('request.construct',$this);
		if(!empty($_POST)){
			$this->data = (object)$_POST;
		}
		if(!empty($_FILES)){
			$this->initFiles();
		}
	}

	public function securePost(){
		if($this->isPost()){
			$csrf = Session::get('skankydev.form.csrf');
			//debug($_FILES);debug($_POST);die();
			if($csrf){
				$token = isset($_POST['_token'])?$_POST['_token']:getallheaders()['X-Param-Token'];
				if(!$csrf->checkValue($token) || !$csrf->checkTime()){
					throw new Exception("CRSF error", 500);
				}else{
					//Session::delete('skankydev.form.csrf');
					unset($this->data->_token);
				}
			}
		}
	}

	public function getData($secure = true){
		if($secure){
			$this->securePost();
		}
		return $this->data;
	}

	/**
	 * get value form $_POST
	 * @param  string $name value
	 * @return mixed       $_POST | $_POST[$name]
	 */
	public function getPost($name = ''){
		if($this->isPost()){
			if(empty($name)){
				return $_POST;
			}else{
				return $this->arrayGet($name,$_POST);
			}
		}
		return false;
	}

	/**
	 * get value form $_GET
	 * @param  string $name value
	 * @return mixed       $_GET | $_GET[$value]
	 */
	public function getGet($name = ''){
		if(empty($name)){
			return $_GET;
		}else{
			return $_GET[$name];
		}
	}

	/**
	 * get $_FILES
	 * @return array $_FILES
	 */
	public function getFiles($name = ''){
		if(empty($this->files)){
			return false;
		}
		if(!empty($name)){
			return $this->files[$name];
		}
		return $this->files;
	}

	/**
	 * convert $_FILES to a prety array
	 * @return void 
	 */
	public function initFiles(){

		$this->files = [];
		foreach ($_FILES as $field => $files) { //pour tout les input file
			$test = current($files);
			if(is_array($test)){ //si multiple
				foreach ($files as $index => $value) { //convertion du tableau
					foreach ($value as $key => $v) {
						$this->files[$field][$key][$index] = $v;
					}
				}
			}else{ //sinon tout va bien
				$this->files[$field] = $files;
			}
		}
	}

	/**
	 * ca viendra un jour enfin je suis pas bien sur
	 * @param  string $name [description]
	 * @return [type]       [description]
	 */
	public function getParams($name = ''){
		//ca marche pas
		if(empty($name)){
			return $this->params;
		}else{
			return $this->params[$name];
		}
	}

	/**
	 * redirect the request to a new link
	 * @param  array  $link a array description of the link
	 */
	public function redirect($link = []){
		//doit etre deplacer
		EventManager::getInstance()->event('request.redirect',$this);
		Auth::getInstance()->notDirect();
		$url ='';
		if(is_string($link)){
			$url = $this->url(Router::getInstance()->getRouteByName($link));			
		}else{
			$url = $this->url($link);
		}
		header('Location: '.$url);
		exit();
	}

	/**
	 * check if the request is poste
	 * @return boolean true or false
	 */
	public function isPost(){
		return ($this->method === 'POST');
	}

	/**
	 * creat the url 
	 * @param  array  $link ['controller'=>'','action'=>'','params'=>['name'=>'value','name'=>'value'...]]
	 * @return string       the absolut url;
	 */
	public function url($link = [], $absolut = true){
		return UrlBuilder::_build($link, $absolut);
	}

	/**
	 * get current link as array
	 * @return array link information
	 */
	public function getArrayLink(){
		$link['namespace'] = $this->namespace;
		$link['controller'] = $this->controller;
		$link['action'] = $this->action;
		$link['params'] = $this->params;
		return $link;
	}

	static function getCurentUrl(){
		//$request->sheme$request->host.$request->uri;
		return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}



}
