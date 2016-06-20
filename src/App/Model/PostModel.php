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

class PostModel extends NoSqlModel {
	
	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
		$validator->addRules(['name'],['notEmpty'],'ne doit pas etre vide');
		$validator->addRules(['slug'],['notEmpty','regex'=>['preg'=>'/^[a-z0-9\-\']*$/']],'le slug doit être séparé par des \'-\' ');
		$validator->trimTag(['name','slug']);
	}

	public function findBySlug($slug = ''){
		if(empty($slug)){
			throw new \Exception("page not found", 404);
		}
		$post = $this->findOne(['slug'=>$slug]);
		if(!isset($post->slug)){
			throw new \Exception("page not found", 404);
		}
		return $post;
	}

}
