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

include_once 'Utilities'.DS.'Debug.php';
include_once 'Config'.DS.'Config.php'; 

use SkankyDev\Request;
use SkankyDev\Router;
use SkankyDev\MasterView;
use SkankyDev\EventManager;
use SkankyDev\Config\Config;
use SkankyDev\Utilities\Session;
use SkankyDev\Controller\MasterController;
use SkankyDev\Controller\ErrorController;
use Exception;

class Application {
	
	public function __construct() {
		try {
			Config::getConf();
			Auth::loadClass();//we c'est un peux de la triche
			Session::start();
			EventManager::init();
			$this->request = Request::getInstance();
			$this->router = Router::getInstance();
			$this->auth = Auth::getInstance();
			$this->auth->checkFirstStep();
			include_once APP_FOLDER.DS.'config'.DS.'bootstrap.php';
			$this->request->securePost();

			$view = $this->router->execute();
			$view->render();
		} catch (Exception $e) {
			$this->controller = new ErrorController($e);
		}
	}
}
