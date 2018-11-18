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
use SkankyDev\Model\MasterModel;

class PostModel extends NoSqlModel {
	
	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
		$validator->addRules(['name'],['notEmpty'],'ne doit pas etre vide');
		$validator->addRules(['slug'],['notEmpty','regex'=>['preg'=>'/^[a-z0-9\-\']*$/']],'le slug doit être séparé par des \'-\' ');
		$validator->trimTag(['name','slug']);
	}


	public function install(){
		try {
			$client = MongoClient::getInstance();
			$option = [];
			$option['autoIndexId'] = true;
			$client->createCollection('post',$option);
			$index = [];
			$index[0] = ['key'=>['slug'=>1],'name'=>'slug','unique'=>true];
			$client->createIndex('post',$index);
			return 'PostModel has been configured';
		} catch (\MongoDB\Driver\Exception\RuntimeException $e) {
			return 'PostModel: '.$e->getMessage();
		}

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

	public function create($post){
		$post->media = [];
		$dir = PUBLIC_FOLDER.DS.'img'.DS.'upload'.DS.$post->slug;
		if(!file_exists($dir)){
			mkdir($dir,0755,true);
		}
		return $this->save($post);
	}

	public function remove($slug){
		$post = $this->findBySlug($slug);
		$messageModel = $this->load('App\Model\MessageModel',true);
		$messageModel->collection->deleteMany(['post_id'=>$post->_id]);
		if($this->delete(['slug' => $slug])){
			$dir = PUBLIC_FOLDER.DS.'img'.DS.'upload'.DS.$slug;
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

	public function addMedia($slug,$media){
		return $this->collection->findOneAndUpdate(['slug'=>$slug],['$push'=>['media'=>$media]]);
	}

}
