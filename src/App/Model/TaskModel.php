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

class TaskModel extends NoSqlModel {

	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
		$validator->addRules(['tache'],['notEmpty','regex'=>['preg'=>'/^[a-zA-Z0-9]*$/']],'que des alphanumériques');
		$validator->addRules(['message','criticite'],['notEmpty'],'ne doit pas être vide');
		$validator->trimTag(['tache','message','statu','criticite']);
	}

}
