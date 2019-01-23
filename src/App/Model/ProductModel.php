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


class ProductModel extends NoSqlModel {

	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
		$validator->addRules(['name','ref','prix'],['notEmpty'],'ne doit pas etre vide');
		$validator->addRules(['prix'],['isNum'],'doit etre un nombre');
		$validator->addRules(['ref'],['regex'=>['preg'=>'/^[a-zA-Z0-9]*$/']],'doit contenir que des caractère alphanumérique');
		$validator->trimTag(['name','ref']);
	}

	public function install(){
		try {
			$client = MongoClient::getInstance();
			$option = [];
			$option['autoIndexId'] = true;
			$client->createCollection('product',$option);
			$index = [];
			$index[0] = ['key'=>['ref'=>1],'name'=>'ref','unique'=>true];
			$client->createIndex('product',$index);
			return 'ProductModel has been configured';			
		} catch (\MongoDB\Driver\Exception\RuntimeException $e) {
			return 'ProductModel: '.$e->getMessage();
		}
	}

	public function remove($_id){
		$product = $this->findById($_id);
		if($this->delete(['_id'=>$_id])){
			$dir = PUBLIC_FOLDER.DS.'img'.DS.'product'.DS.$product->ref;
			$dirContent = scandir($dir);
			foreach ($dirContent as $file) {
				if(is_file($dir.DS.$file)){
					unlink($dir.DS.$file);
				}
			}
			rmdir($dir);
			return true;
		}else{
			return false;
		}
	}

	public function addMedia($ref,$media){
		return $this->collection->findOneAndUpdate(['ref'=>$ref],['$push'=>['media'=>$media]]);
	}

}
