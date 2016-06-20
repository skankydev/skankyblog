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

use SkankyDev\Factory;
use SkankyDev\Config\Config;
use SkankyDev\Utilities\Traits\StringFacility;
use SkankyDev\Utilities\Interfaces\PermissionInterface;

class Router
{

	use StringFacility;

	private $routes = [];
	private static $_instance = null;

	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new Router();
		}
		return self::$_instance;
	}


	function __construct() {
		$request = Request::getInstance();
		$this->routes = Config::getRoutes();
		$params = [];
		$tmp = explode('?', $request->uri);
		$uri = $tmp[0];
		if(array_key_exists($uri, $this->routes)){
			$request->namespace  = $this->routes[$uri]['options']['namespace'];
			$request->controller = ucfirst($this->routes[$uri]['options']['controller']);
			$request->action     = $this->routes[$uri]['options']['action'];
			if(isset($this->routes[$uri]['params'])){
				$request->params     = $this->routes[$uri]['params'];
			}
		}else{
			$uri = trim($uri,'/');
			$tmp = explode('/', $uri);
			$modules = Config::getModuleList();
			$namespace = $this->toCap($tmp[0]);
			if(in_array($namespace, $modules)){
				$request->namespace = $namespace;
				array_shift($tmp);
			}else{
				$request->namespace  = Config::getDefaultNamespace();
			}
			$request->controller = $this->toCap($tmp[0]);
			$request->action     = isset($tmp[1]) ? lcfirst($this->toCap(trim($tmp[1],'_'))) : Config::getDefaultAction();

			if(isset($tmp[2])&&!empty($tmp[2])){
				$request->params = array_slice($tmp,2);
			}
		}
		Config::setCurentNamespace($request->namespace);
		EventManager::getInstance()->event('router.construct',$this);
	}
	/**
	 * return root by name
	 * @param  string $name the name
	 * @return array       	$link
	 */
	function getRouteByName($name){
		$retour = false;
		if(array_key_exists($name, $this->routes)){
			$retour = $this->routes[$name]['options'];
		}
		return $retour;
	}

	private function makeControllerName($link=[]){
		if(empty($link)){
			$request = Request::getInstance();
			return $request->namespace.'\\Controller\\'.$request->controller.'Controller';
		}else{
			return $link['namespace'].'\\Controller\\'.$link['controller'].'Controller';
		}

	}

	public function execute(){
		EventManager::getInstance()->event('router.execute.before',$this);
		$request = Request::getInstance();
		$link = $request->getArrayLink();
		$controller = Factory::load($this->makeControllerName($link));

		$method = new \ReflectionMethod($controller,$link['action']);
		if(!isset($this->permission)){
			$method->invokeArgs($controller,$link['params']);
		}else{
			if($method->isPublic()){
				if($this->permission->checkPublicAccess($link)){
					$method->invokeArgs($controller,$link['params']);
				}else{
					$request->redirect(Config::get('Auth.redirectAction'));
				}
			}elseif($method->isProtected()){
				if($this->permission->checkProtectedAccess($link)){
					$method->setAccessible(true);
					$method->invokeArgs($controller,$link['params']);
				}else{
					$request->redirect(Config::get('Auth.redirectAction'));
				}
			}elseif($method->isPrivate()){
				if($this->permission->checkPrivateAccess($link)){
					$method->setAccessible(true);
					$method->invokeArgs($controller,$link['params']);
				}else{
					$request->redirect(Config::get('Auth.redirectAction'));
				}
			}
		}
		EventManager::getInstance()->event('router.execute.after',$this);
		return $controller->_getView();
	}

	public function getElement($link){
		EventManager::getInstance()->event('router.element.before',$this);
		$cName = $this->makeControllerName($link);
		$controller = Factory::load($cName);
		$method = new \ReflectionMethod($controller,$link['action']);
		if(!isset($this->permission)){
			$method->invokeArgs($controller,$link['params']);
			return $controller->_getView();	
		}else{
			if($method->isPublic()){
				if($this->permission->checkPublicAccess($link)){
					$method->invokeArgs($controller,$link['params']);
					return $controller->_getView();	
				}
			}elseif($method->isProtected()){
				if($this->permission->checkProtectedAccess($link)){
					$method->setAccessible(true);
					$method->invokeArgs($controller,$link['params']);
					return $controller->_getView();	
				}
			}elseif($method->isPrivate()){
				if($this->permission->checkPrivateAccess($link)){
					$method->setAccessible(true);
					$method->invokeArgs($controller,$link['params']);
					return $controller->_getView();	
				}
			}
		}
		EventManager::getInstance()->event('router.element.after',$this);
		return false;
			
	}

	public function setPermissionManager($interface){
		if($interface instanceof PermissionInterface){
			$this->permission = $interface;
			return true;
		}
		return false;
	}
}