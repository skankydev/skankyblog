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

use SkankyDev\Config\Config;
/**
* 
*/
class MasterCollection
{
	protected $collectionName;
	protected $behavior = [];

	/**
	 * construct
	 * @param string $name the name of the collection
	 */
	function __construct($name){
		$this->collectionName = strtolower($name);
		$this->loadBehavior();
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
	 * @param  array &$data    the data from databas or from entity
	 * @param  entity &$entity the entity if it's need update on create  
	 * @return void
	 */
	protected function callBehavior($method,&$data,&$entity=null){
		if(!empty($this->behavior)){
			foreach ($this->behavior as $key => $value) {
				$name = is_array($value)?$key:$value;
				$this->$name->$method($data,$entity);
			}
		}
	}

	/**
	 * create new entity
	 * @param  array $data the data
	 * @return entity
	 */
	public function createEntity($data){
		$tmp = explode('\\', get_class($this));
		$entity = str_replace('sCollection','',$tmp[3]);

		$eName = $tmp[0].'\\Model\\Entity\\'.$entity;
		unset($tmp);
		$this->callBehavior('beforeCreateEntity',$data);
		$entity = Factory::load($eName,['data'=>$data]);
		$this->callBehavior('afterCreateEntity',$data,$entity);
		return $entity;
	}

	/**
	 * load a Collection 
	 * @param  string $name the name
	 * @return mixed        a collection
	 */
	static function load($name){
		
		$cName = Config::getCurentNamespace().'\\Model\\Collection\\'.$name.'Collection';
		return Factory::load($cName,['name'=>$name],false);
	}


}