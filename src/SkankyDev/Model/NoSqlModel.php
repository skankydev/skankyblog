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

use SkankyDev\Model\MasterModel;
use SkankyDev\Config\Config;
use SkankyDev\Utilities\Paginator;
use SkankyDev\Database\MongoClient;
use SkankyDev\EventManager;
use SkankyDev\Factory;

use MongoDB\BSON\ObjectID;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Exception\BulkWriteException;

class NoSqlModel extends MasterModel {
	
	private $defaultQuery = ['query'=>[]];

	function __construct($name) {
		parent::__construct($name);
		$name = strtolower($name);
		$this->collection = MongoClient::getInstance()->getCollection($name);

		$this->defineDocument();
	}

	public function defineDocument(){
		$tmp = explode('\\', get_class($this));
		$document = str_replace('Model','',$tmp[2]);
		$docName = $tmp[0].'\\Model\\Document\\'.$document;
		unset($tmp);
		Factory::loadFile($docName);
	}

	/**
	 * insert or update data 
	 * @param  document  $document the data
	 * @return void
	 */
	public function save($document){
		try {
			if(!empty($document->_id)){
				$this->update($document);
			}else{
				$this->insert($document);
			}
			return true;
		} catch (BulkWriteException $e) {
			$tmp = $e->getWriteResult()->getWriteErrors();
			$tmp = current($tmp);
			if($tmp->getCode()===11000){
				$var = explode(':', $tmp->getMessage());
				$var = explode(' ', $var[2]);
				$var = $var[1];
				$document->messageValidate[$var] = _('is already used');
				return false;
			}
			throw $e;
		}
	}
	
	/**
	 * insert data to database
	 * @param  array $data  the formatede array for database
	 * @return void
	 */
	public function insert($document){
		try {
			$this->callBehavior('beforeInsert',$document);
			$result = $this->collection->insertOne($document);
			EventManager::getInstance()->event('model.query.insert',$this,$document);
			$this->callBehavior('afterInsert',$document);
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * update data to database
	 * @param  array $data  the formatede array for database
	 * @return void
	 */
	public function update($document){
		try {
			$this->callBehavior('beforeUpdate',$document);
			$result = $this->collection->updateOne(['_id'=>$document->_id],['$set'=>$document]);
			EventManager::getInstance()->event('model.query.update',$this,$document);
			$this->callBehavior('afterUpdate',$document,$result);
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * find query
	 * @param  array   $query the query
	 * @return array          document liste
	 */
	public function find($option = []){
		$option = array_replace_recursive($this->defaultQuery,$option);
		$this->convertId($option['query']);
		$query = $option['query'];
		EventManager::getInstance()->event('model.query.find',$this,$option);
		unset($option['query']);
		$cursor = $this->collection->find($query,$option);
		//return $cursor;
		$retour = [];
		foreach ($cursor as $document) {
			$retour[] = $document;
		}
		return $retour;
	}

	/**
	 * find firest result of query
	 * @param  array  $query the query
	 * @return document     the document
	 */
	public function findOne($query = []){
		EventManager::getInstance()->event('model.query.findOne',$this,$query);
		$cursor = $this->collection->find($query);
		$retour = false;
		$a = $cursor->toArray();
		if(!empty($a)){
			$retour = $a[0];
		}
		return $retour;
	}

	/**
	 * find a document by id 
	 * @param  string $id the id of document
	 * @return document     the document
	 */
	public function findById($id =''){
		$id = new ObjectID($id);
		$query = ['_id'=>$id];
		EventManager::getInstance()->event('model.query.findById',$this,$query);
		$cursor = $this->collection->find(['_id'=>$id]);
		$retour = false;
		$a = $cursor->toArray();
		if(!empty($a)){
			$retour = $a[0];
		}
		return $retour;
	}

	/**
	 * count document in collection
	 * @param  array  $query the query
	 * @return int           the total
	 */
	public function count($query = []){
		EventManager::getInstance()->event('model.query.count',$this,$query);
		return $this->collection->count($query);
	}

	/**
	 * prepare query for pagination
	 * @param  array                          $option the option for query
	 * @return SkankyDev\Utilities\Paginator          the paginator object
	 */
	public function paginate($option = []){
		$option = array_replace_recursive($this->defaultQuery,$option);
		$dOption = Config::get('paginator');
		$option = array_replace_recursive($dOption,$option);
		if(!$option['page']){
			$option['page'] = 1;
		}
		$option['skip'] = $option['limit']*($option['page']-1);
		$option['count'] = $this->count($option['query']);
		$result = $this->find($option);
		$paginator = new Paginator($result);
		unset($option['query']);
		unset($option['skip']);
		$paginator->setOption($option);

		return $paginator;
	}

	/**
	 * delete document
	 * @param  array  $query the query
	 * @return MongoDB\DeleteResult | false
	 */
	public function delete($query = []){
		if(!empty($query)){
			EventManager::getInstance()->event('model.query.delete',$this,$query);
			return $this->collection->deleteOne($query);
		}
		return false;
	}

	public function convertId($data){
		foreach ($data as $key => $value) {
			if(preg_match('/[a-zA-Z0-9_-]*_id/', $key)){
				$data[$key] = new ObjectID($value);
			}
		}
	}

	public function createId($string){
		return new ObjectID($string);
	}
}
