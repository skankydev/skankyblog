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
namespace SkankyDev\Controller;

use SkankyDev\Config\Config;
use SkankyDev\Model\MasterModel;
use SkankyDev\MasterView;
use SkankyDev\Factory;
use SkankyDev\Request;
use SkankyDev\EventManager;
/**
* 
*/
class MasterController {

	public $request;
	public $viewModel = 'SkankyDev\View\HtmlView';
	public $collection = 'default';
	public $tools = [
		'Flash',
	];

	
	/**
	 * construct
	 * c'est le bordel ici
	 * @param Request $request the request
	 */
	public function __construct(){
		EventManager::getInstance()->event('controller.construct',$this);
		$this->request = Request::getInstance();
		
		$name = explode('\\',get_class($this));
		
		if($this->collection === 'default'){
			$modelName = str_replace('Controller','',$name[2]);
		}else{
			$modelName = $this->collection; 
		}
		$this->{$modelName} = MasterModel::load($modelName);
		$this->_loadTools();
		$this->_iniView();
	}

	public function _iniView(){
		$this->view = Factory::load($this->viewModel);
	}

	/**
	 * creat tools for controller
	 * @return void
	 */
	public function _loadTools(){
		$def = Config::getTools();
		foreach ($this->tools as $tool => $params) {
			if(is_array($params)){
				$className = $def[$tool];
				$this->{$tool} = Factory::load($className,$params);
			}else{
				$className = $def[$params];
				$this->{$params} = Factory::load($className);
			}
		}
	}

	public function _getView(){
		return $this->view;
	}

}