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

class ProfilModel extends NoSqlModel {

	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
		$validator->addRules(['nom','prenom','civilite','telephone'],['notEmpty'],'ne doit pas etre vide');
		$validator->trimTag(['nom','prenom']);
	}

	public function install(){
		try {
			$client = MongoClient::getInstance();
			$option = [];
			$option['autoIndexId'] = true;
			$client->createCollection('profil',$option);
			$index = [];
			$index[0] = ['key'=>['user_email'=>1],'name'=>'user_email','unique'=>true];
			$client->createIndex('profil',$index);
			return 'ProfilModel has been configured';			
		} catch (\MongoDB\Driver\Exception\RuntimeException $e) {
			return 'ProfilModel: '.$e->getMessage();
		}
	}

	public function addAdresse($user_email,$adresse){
		return $this->collection->findOneAndUpdate(['user_email'=>$user_email],['$push'=>['adresse'=>$adresse]]);
	}
}
