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

class TaxonomieModel extends NoSqlModel {

	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
		$validator->addRules(['name'],['notEmpty'],'ne doit pas etre vide');
		$validator->trimTag(['name']);
	}

	public function install(){
		return 'TaxonomieModel need to be done';
	}

	public function getList(){
		$tags = $this->find();
		$list = [];
		foreach ($tags as $key => $value) {
			$list[] = $value->name;
		}
		return $list;
	}
}
