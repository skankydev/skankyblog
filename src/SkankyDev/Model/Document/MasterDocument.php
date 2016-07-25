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

namespace SkankyDev\Model\Document;

use MongoDB\BSON\Persistable;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectID;
use MongoDB\Model\BSONArray;
use DateTime;

class MasterDocument implements Persistable{

	public $_id;

	public function __construct(array $data){
		$properties = get_class_vars(get_class($this));
		foreach ($properties as $key=>$value){
			if(isset($data->{$key})){
				$this->{$key} = $data->{$key};
				if(preg_match('/[a-zA-Z0-9_-]*_id/', $key)){
					if(empty($data->{$key})){
						$this->{$key} = new ObjectID();
					}else{
						$this->{$key} = new ObjectID($data->{$key});
					}
				}
			}
		}
	}

	/**
	 * convert the document to be saved in database
	 * @return array the document
	 */
	public function bsonSerialize(){
		$prop = get_object_vars($this);
		foreach ($prop as $key=>$value) {
			$prop[$key] = $this->{$key};
			if($prop[$key] instanceof DateTime){
				$prop[$key] = new UTCDateTime(strtotime($this->{$key}->format("Y-m-d H:i:s")));
			}else if(preg_match('/[a-zA-Z0-9_-]*_id/', $key)){
				if(empty($value)){
					$prop[$key] = new ObjectID();
				}else{
					$prop[$key] = new ObjectID($value);
				}
			}
		}
		return $prop;
	}

	/**
	 * convert the result to the database in document
	 * @param  array  $data the data form database
	 * @return void
	 */
	public function bsonUnserialize(array $data){
		unset($data['__pclass']);
		foreach ($data as $key => $value) {
			$this->{$key} = $value;
			if($this->{$key} instanceof UTCDateTime ){
				$date = $this->{$key};
				$myDate = new DateTime();
				$ts = (int)$date->__toString();
				$myDate->setTimestamp($ts);
				$this->{$key} = $myDate;
			}elseif($this->{$key} instanceof BSONArray){
				$this->{$key} = $this->{$key}->getArrayCopy();
			}
		}
	}

}
