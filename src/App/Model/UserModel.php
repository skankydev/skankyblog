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

class UserModel extends NoSqlModel {

	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
		$validator->addRules(['username','password','email'],['notEmpty'],'ne doit pas etre vide');
		$validator->addRules(['username'],['regex'=>['preg'=>'/^[a-zA-Z0-9_-]{3,16}$/']],'doit contenir que des caractères alphanumériques');
		$validator->addRules(['password'],['minLength'=>['min'=>8]],'doit contenir au moins huit caractères');
		$validator->addRules(['email'],['isEmail'],'doit être une adresse mail valide');
		$validator->trimTag(['username','email']);
	}

}
