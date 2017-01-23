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
			$client->createIndex('post',$index);
			return 'ProductModel has been configured';			
		} catch (\MongoDB\Driver\Exception\RuntimeException $e) {
			return 'ProductModel already exists';
		}
	}
}
