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

namespace App\Model;

use SkankyDev\Model\NoSqlModel;
use SkankyDev\Database\MongoClient;

class MenuModel extends NoSqlModel {

	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
	
	}

	public function install(){
		try {
			$client = MongoClient::getInstance();
			$option = [];
			$option['autoIndexId'] = true;
			$client->createCollection('menu',$option);
			$index = [];
			$index[0] = ['key'=>['name'=>1],'name'=>'name','unique'=>true];
			$client->createIndex('menu',$index);
			return 'MenuModel has been configured';			
		} catch (\MongoDB\Driver\Exception\RuntimeException $e) {
			return 'MenuModel: '.$e->getMessage();
		}	
	}

	public function findMenu($name){
		$menu = $this->collection->findOne(['name'=>$name]);
		return $menu;
	}
}
	