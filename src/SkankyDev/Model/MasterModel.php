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
namespace SkankyDev\Model;

use SkankyDev\Config\Config;
use SkankyDev\Factory;
use SkankyDev\EventManager;

class MasterModel
{
	protected $collectionName;
	protected $behavior = [];
	protected $validatorName = 'SkankyDev\Utilities\Validator';

	/**
	 * construct
	 * @param string $name the name of the collection
	 */
	function __construct($name){
		$this->collectionName = strtolower($name);
		$this->loadBehavior();
		EventManager::getInstance()->event('model.construct',$this);
	}

	/**
	 * load behavior
	 * @return void
	 */
	public function loadBehavior(){
		$def = Config::getBehavior();
		//debug($def);
		foreach ($this->behavior as $behavior => $params) {
			if(is_array($params)){
				$className = $def[$behavior];
				$this->{$behavior} = Factory::load($className,$params);
			}else{
				$className = $def[$params];
				$this->{$params} = Factory::load($className);
			}
		}
	}

	/**
	 * call behavior event
	 * @param  string $method  event name
	 * @param  array  &$data   the data from databas or from entity
	 * @param  entity &$entity the entity if it's need update on create  
	 * @return void
	 */
	protected function callBehavior($method,$data,$entity=null){
		if(!empty($this->behavior)){
			foreach ($this->behavior as $key => $value) {
				$name = is_array($value)?$key:$value;
				$this->$name->$method($data,$entity);
			}
		}
	}

	/**
	 * load a Model 
	 * @param  string $name the shor name of the model (ex: Data is for App\Model\DataModel)
	 * @param  bool   $full if the class name is full (default not full)
	 * @return mixed        a collection
	 */
	static function load($name,$full = false){
		if(!$full){
			$cName = Config::getCurentNamespace().'\\Model\\'.$name.'Model';
		}else{
			$cName = $name;
			$name = explode('\\', $name);
			$name = end($name);
			$name = str_replace('Model', '', $name);
		}
		return Factory::load($cName,['name'=>$name],false);
	}

	/**
	 * create new Document
	 * @param  array $data the data
	 * @return entity
	 */
	public function createDocument($data){
		$tmp = explode('\\', get_class($this));
		$document = str_replace('Model','',$tmp[2]);
		//debug($data);
		$eName = $tmp[0].'\\Model\\Document\\'.$document;
		unset($tmp);
		$this->callBehavior('beforeCreateEntity',$data);
		$document = Factory::load($eName,['data'=>$data]);
		$this->callBehavior('afterCreateEntity',$data,$document);
		return $document;
	}

	public function isValid($data){
		$validator = Factory::load($this->validatorName);
		$this->initValidator($validator);
		return $validator->valid($data);
	}

	public function initValidator($validator){}
}
