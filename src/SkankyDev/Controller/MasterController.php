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
use SkankyDev\EventManager;
use SkankyDev\Exception\ClassNotFoundException;
use SkankyDev\Factory;
use SkankyDev\MasterView;
use SkankyDev\Model\MasterModel;
use SkankyDev\Request;
use SkankyDev\View\ViewBuilder;
/**
* 
*/
class MasterController {

	protected $request;
	protected $viewModel = 'SkankyDev\View\HtmlView';
	protected $collection = 'default';
	protected $tools = [];

	
	/**
	 * construct
	 * c'est le bordel ici
	 * @param Request $request the request
	 */
	public function __construct(){
		EventManager::getInstance()->event('controller.construct',$this);
		$this->request = Request::getInstance();
		$this->view = ViewBuilder::getInstance();
		$name = explode('\\',get_class($this));
		
		if($this->collection === 'default'){
			$modelName = str_replace('Controller','',$name[2]);
		}else{
			$modelName = $this->collection; 
		}
		$this->{$modelName} = MasterModel::load($modelName);
		$this->_init();
	}

	protected function _init(){
		$this->_addTools('Flash');
	}


	/**
	 * Add new tools
	 * @param array|string $tools   the nam of Tool or combo tool => params
	 * @param array        $params  the params for the tool constructor      
	 */
	public function _addTools($tools,$params = []){
		if(is_array($tools)){
			foreach ($tools as $tool => $params) {
				if(is_array($params)){
					$className = Config::getTools($tool);
					if(!$className){
						throw new ClassNotFoundException('No class found for '.$tool.' in '.get_class($this).'',201);
					}
					$this->{$tool} = Factory::load($className,$params);
				}else{
					$className = Config::getTools($params);
					if(!$className){
						throw new ClassNotFoundException('No class found for '.$tool.' in '.get_class($this).'',201);
					}
					$this->{$params} =  Factory::load($className);
				}
			}
		}else if(is_string($tools)){
			$className = Config::getTools($tools);
			if(!$className){
				throw new ClassNotFoundException('No class found for '.$tool.' in '.get_class($this).'',201);
			}
			$this->{$tools} = Factory::load($className,$params);
		}
	}

	public function _addHelpers($name,$params = []){
		$this->view->addHelpers($name,$params);
		/*Factory::load($this->viewModel);
		if( isset($this->helpers) && !empty($this->helpers)){
			$this->view->addHelper($this->helpers);
		}*/
	}


	public function _loadModel($name){
		return MasterModel::load($name);
	}

	public function _getView(){
		return $this->view;
	}

}