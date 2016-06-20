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
namespace Skankydev;

class MasterEntity {
	
	protected $properties = [];
	protected $valid = true;
	public $messageValidate = [];

	/**
	 * create the entity object fom data array 
	 * @param array $data the propertis of the object
	 */
	public function __construct($data){
		foreach ($this->properties as $key => $value) {
			$name = is_array($value)?'key':'value';
			if(isset($data->{$$name})){
				$this->{$$name} = $data->{$$name};
			}
		}
	}

	/**
	 * converte the entity to array
	 * @return array properties => value
	 */
	public function toArray(){
		$data = [];
		foreach ($this->properties as $key => $value) {
			$name = is_array($value)?'key':'value';
			if(isset($this->{$$name})){
				$data[$$name] = $this->{$$name};
			}
		}
		return $data;
	}

	/**
	 * check if data is valide and update this
	 * @param  array  $data the new data
	 * @return boolean      valide or not
	 */
	public function isValid($data = null){
		if ($data == null) {
			$data = $this;
		}
		$method = get_class_methods($this);
		$retour = $this->valid;
		foreach ($this->properties as $key => $value) {
			$name = 'value';
			if(is_array($value)){
				$name = 'key';
				if(isset($value['validator'])&&(isset($this->{$$name}))){
					if(in_array($value['validator']['rulse'], $method)){
						if($this->{$value['validator']['rulse']}($data->$key)){
							$this->messageValidate[$key] = $value['validator']['message'];
							$retour = false;
						}
					}else if(!preg_match($value['validator']['rulse'], $data->$key)){
						$this->messageValidate[$key] = $value['validator']['message'];
						$retour = false;
					}
				}
			}
			if(isset($data->$$name)){
				$this->{$$name} = $data->$$name;
			}else if(isset($this->{$$name})){
				unset($this->{$$name});
			}
		}
		return $retour;
	}
}
