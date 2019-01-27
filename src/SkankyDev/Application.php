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
use SkankyDev\Controller\ErrorController;
use SkankyDev\Controller\MasterController;
use SkankyDev\EventManager;
use SkankyDev\MasterView;
use SkankyDev\Request;
use SkankyDev\Routing\Dispatcher;
use SkankyDev\Routing\Router;
use SkankyDev\Utilities\Session;

if ( !defined('DS') ){
	define('DS', DIRECTORY_SEPARATOR);
}

if ( !defined('APP_FOLDER') ){
	define('APP_FOLDER', dirname(dirname(__DIR__)));
}

if ( !defined('PUBLIC_FOLDER') ){
	define('PUBLIC_FOLDER',APP_FOLDER.DS.'public');
}

//include_once 'Utilities'.DS.'Debug.php';
//include_once 'Config'.DS.'Config.php'; 


class Application {
	
	public function __construct() {
		try {
			Config::getConf();
			Auth::loadClass();//we c'est un peux de la triche
			Session::start();
			EventManager::init();
			include_once APP_FOLDER.DS.'config'.DS.'bootstrap.php';
			include_once APP_FOLDER.DS.'config'.DS.'routes.php';
			$this->request = Request::getInstance();
			$current = Router::_findCurrentRoute($this->request->uri);
			//debug($current);
			$this->auth = Auth::getInstance();
			$this->auth->checkFirstStep();
			//$this->request->securePost();

			$view = Dispatcher::_execute($current);
			$view->render();
		} catch (Exception $e) {
			$this->controller = new ErrorController($e);
		}
	}
}
