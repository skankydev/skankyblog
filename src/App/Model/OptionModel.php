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

class OptionModel extends NoSqlModel {

	protected $behavior = [];

	public function initValidator($validator){
	
	}

	public function install(){
		try {
			$client = MongoClient::getInstance();
			$option = [];
			$client->createCollection('option',$option);
			$index = [];
			$index[0] = ['key'=>['name'=>1],'name'=>'name','unique'=>true];
			$client->createIndex('option',$index);
			return 'OptionModel has been configured';			
		} catch (\MongoDB\Driver\Exception\RuntimeException $e) {
			return 'OptionModel: '.$e->getMessage();
		}	
	}

	public function getNexCommandeNum(){
		$num = $this->collection->findOneAndUpdate(
			['name' => 'numCom'],
			['$inc' => ["value" => 1]],
			[
				'upsert'=>true,
				'returnDocument' => \MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER,
			]
		);
		return $num->value;
	}
}
