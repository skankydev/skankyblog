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
use MongoDB\Driver\BulkWrite;
use MongoDB\BSON\UTCDateTime;

class UserModel extends NoSqlModel {

	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
		$validator->addRules(['login','password','email'],['notEmpty'],'ne doit pas etre vide');
		$validator->addRules(['login'],['regex'=>['preg'=>'/^[a-zA-Z0-9_-]{3,16}$/']],'doit contenir que des caractères alphanumériques');
		$validator->addRules(['password'],['minLength'=>['min'=>8]],'doit contenir au moins huit caractères');
		$validator->addRules(['email'],['isEmail'],'doit être une adresse mail valide');
		$validator->trimTag(['login','email']);
	}

	public function install(){
		$client = MongoClient::getInstance();
		$option = [];
		$option['autoIndexId'] = true;
		$client->createCollection('user',$option);
		$index = [];
		$index[0] = ['key'=>['login'=>1],'name'=>'login','unique'=>true];
		$index[1] = ['key'=>['email'=>1],'name'=>'email','unique'=>true];
		$client->createIndex('user',$index);
		return 'UserModel has been configured';
	}

	public function updateLogin($user){
		$newDate = new UTCDateTime(time());
		return $this->collection->updateOne(['_id'=>$user->_id],['$set'=>['lastLogin'=>$newDate]]);
	}
}
