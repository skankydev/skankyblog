<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @since         0.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */

namespace SkankyDev\Collection;

use SkankyDev\Config\Config;
use SkankyDev\Model\MasterModel;
/*
 * TODO Le PDO Connar !!!!
 *
 */
class SqlCollection extends MasterModel {
	
	public function find($option = array()){
		$link = $this->openConnect();
		$query = 'SELECT ';
		if(isset($option['field'])){
			foreach ($option['field'] as $k) {
				$query .= $k.', ';
			}
			$query = substr($query,0,-2);
		}else{
			$query .= '* ';
		}

		$query .= 'FROM `'.strtolower($this->collectionName).'` ';
		if(isset($option['limit'])){
			$query .= 'LIMIT '.$option['limit'];
		}else{
			$query .= 'LIMIT 30';
		}
		$result = $link->query($query);
		if(!$result){
			throw new \Exception('Échec de la requête : ' . mysqli_error($link));
		}
		$data=array();
		while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
			$data[] = $line;
		}
		$this->closeConnect($link,$result);
		return $data;
	}

	public function read(){
		$link = $this->openConnect();
		$query = 'SELECT * FROM `'.strtolower($this->collectionName).'` WHERE `'. strtolower($this->collectionName) .'`.`id`='.$this->id;
		$result = $link->query($query);
		if(!$result){
			throw new \Exception('Échec de la requête : ' . mysqli_error($link));
		} 
		$data = mysqli_fetch_array($result, MYSQL_ASSOC);
		$this->closeConnect($link,$result);
		return $data;
	}

	public function save($data = array()){
		$link = $this->openConnect();
		$query = '';
		if(empty($this->id)){
		//INSERT
			$key = '';
			$values = '';
			foreach ($data as $k => $v) {
				$key .= '`'.$k.'`, ';
				$values .= '\''.$v.'\', ';
			}
			$key .= '`created`' ;
			$values .= '\''.date("Y-m-d H:i:s").'\'';
			$query .= 'INSERT INTO `'. strtolower($this->collectionName) .'` (`id`, '.$key.') ';
			$query .= 'VALUES (NULL, '.$values.');';
		}else{
			//UPDATE
			if(isset($data['id'])){
				unset($data['id']);
			}
			$query.='UPDATE `'. strtolower($this->collectionName) .'` SET ';
			foreach ($data as $k => $v) {
				$query .= '`'.$k.'` = \''.$v.'\',';
			}
			$query = substr($query,0,-1);
			$query.= 'WHERE `'. strtolower($this->collectionName) .'`.`id`='.$this->id;
		}
		$result = $link->query($query);
		if(!$result){
			throw new \Exception('Échec de la requête : ' . mysqli_error($link));
		}
		if(empty($this->id)){
			$this->id = mysqli_insert_id($link);
		}
		$this->closeConnect($link);
		return true;
	}

	public function delete(){
		$link = $this->openConnect();
		$query = 'DELETE FROM `'.strtolower($this->collectionName).'` WHERE `'. strtolower($this->collectionName) .'`.`id`='.$this->id;
		$result = $link->query($query);
		if(!$result){
			throw new \Exception('Échec de la requête : ' . mysqli_error($link));
		}
		$this->closeConnect($link);
		return true;
	}


	public function _query($query){
		$link = $this->openConnect();
		$result = $link->query($query);
		if(!$result){
			throw new \Exception('Échec de la requête : ' . mysqli_error($link));
		}
		$data=array();
		while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
			$data[] = $line;
		}
		$this->closeConnect($link,$result);
		return $data;
	}

	private function openConnect(){
		$dbConnect = Config::getDbConf('MySQL');
		$link = mysqli_connect($dbConnect['host'],$dbConnect['user'],$dbConnect['pass']);
		if(!$link){
			throw new \Exception('Impossible de se connecter : ' . mysqli_error($link));
		}
		mysqli_select_db($link,$dbConnect['database']);
		if(!$link){
			throw new \Exception('Impossible de sélectionner la base de données : ' . mysqli_error($link));
		}
		return $link;
	}

	private function closeConnect($link,$result = false){
		if($result){mysqli_free_result($result);}

		mysqli_close($link);
	}
}