<?php 
namespace App\Model;

use SkankyDev\Model\NoSqlModel;
use SkankyDev\Database\MongoClient;

class PermissionModel extends NoSqlModel {

	protected $behavior = [];

	public function initValidator($validator){
		$validator->addRules(['name'],['notEmpty'],'ne doit pas etre vide');
		$validator->trimTag(['name']);
	}

	public function install(){
		$client = MongoClient::getInstance();
		$option = [];
		$option['autoIndexId'] = true;
		try {
			$client->createCollection('permission',$option);
			$index = [];
			$index[0] = ['key'=>['name'=>1],'name'=>'name','unique'=>true];
			$client->createIndex('permission',$index);
			return 'PermissionModel has been configured';			
		} catch (\MongoDB\Driver\Exception\RuntimeException $e) {
			return 'PermissionModel :'.$e->getMessage();
			
		}

	}

}
