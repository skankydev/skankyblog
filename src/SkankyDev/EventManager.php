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
use SkankyDev\Utilities\Traits\ArrayPathable;

class EventManager{
	
	use ArrayPathable;
	
	private $event;
	private $listeners;
	private $ready = false;
	private $classListe;
	private static $_instance = false;
	
	/**
	 * get instance of event listener
	 * @return object this
	 */
	public static function getInstance() {
		return self::$_instance;
	}

	/**
	 * initalise the manager 
	 * @return void
	 */
	public static function init(){
		if(!self::$_instance){
			self::$_instance = new EventManager();
		}
	}

	/**
	 * create and atache all listener 
	 */
	function __construct() {
		$classList = Config::getListener();
		$this->listeners = Config::getListenerList();
		foreach ($this->listeners as $listener => $params) {
			if(is_array($params)){
				$name = $listener;
				$className = $classList[$listener];
				$this->{$name} = Factory::load($className,$params);
			}else{
				$name = $params;
				$className = $classList[$params];
				$this->{$name} = Factory::load($className);
			}
			$hook = $this->{$name}->infoEvent();
			foreach ($hook as $key => $action){
				$tmp = $this->arrayGet($key,$this->event);
				$tmp[$name] = $action;
				$this->arraySet($key,$tmp,$this->event);
			}
		}
		$this->ready = true;
		$this->classListe = $classList;
	}
	/**
	 * create a event
	 * @param  string $name    event name
	 * @param  object $subject how have create event
	 * @param  mixed  $arg     the argument list for the events methode
	 * @return void          
	 */
	public function event($name,$subject,...$arg){
		if($this->ready){
			array_unshift($arg, $subject);
			$def = $this->arrayGet($name,$this->event);
			if(empty($def)){
				return false;
			}
			foreach ($def as $object => $method) {
				$method = new \ReflectionMethod($this->$object,$method);
				$method->invokeArgs($this->$object,$arg);
			}
		}
	}


	/**
	 * get one listener
	 * @param  string $name the listener name
	 * @return object       the listener
	 */
	public function getListener($name){
		return $this->{$name};
	}

	/**
	 * get all event attachement
	 * @return array event mapping
	 */
	public function getEventMapping(){
		return $this->event;
	}
	
	/**
	 * get the list of attached listener
	 * @return array listener list
	 */
	public function getListenerListe(){
		return $this->classListe;
	}
	
}
