<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */

namespace App\Controller;

use SkankyDev\Controller\MasterController;
use SkankyDev\MasterModel;

class PostController extends MasterController {
	
	public function index($page=1){
		$option = [
			'limit'=> 5,
			'query'=> [],
			'sort' => ['created'=> -1],
			'page'=>(int)$page,
		];
		$posts = $this->Post->paginate($option);
		$this->view->set( ['posts' => $posts] );
	}

	public function view($slug=''){
		$post = $this->Post->findBySlug($slug);
		$this->view->set(['post' => $post]);
	}

	private function list($page = 1,$field = 'created',$order = -1){
		$option = [
			'limit'=> 25,
			'query'=> [],
			'page'=>(int)$page,
			'sort' => [],
		];
		$option['sort'][$field] = (int)$order;
		$posts = $this->Post->paginate($option);
		$this->view->set( ['posts' => $posts] );		
	}

	private function add(){

		if($this->request->isPost()){

			$post = $this->Post->createDocument($this->request->data);
			if(empty($post->slug)){
				$post->slug = str_replace(' ', '-', $post->name);
			}

			if($this->Post->isValid($post)){
				if($this->Post->create($post)){
					$this->Flash->set('ça marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ça marche pas',['class' => 'error']);
					$this->request->data = $post;
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $post;
			}
		}
		$tags = $this->_loadModel('taxonomie')->getList();
		$this->view->set(['tags'=>$tags]);
	}

	private function edit($slug = ''){

		$post = $this->Post->findBySlug($slug);
		if($this->request->isPost()){
			$media = $post->media;
			$post = $this->Post->createDocument($this->request->data);
			$post->media = $media;
			if($this->Post->isValid($post)){
				if($this->Post->save($post)){
					$this->Flash->set('ça marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ça marche pas',['class' => 'error']);
				}
			}else{
				$this->Flash->set('ça marche pas',['class' => 'warning']);
			}
		}
		$this->request->data = $post;
		$tags = $this->_loadModel('taxonomie')->getList();
		$this->view->set(['post' => $post,'tags'=>$tags]);
	}

	private function delete($slug = ''){
		if(!empty($slug)){
			if($this->Post->remove($slug)){
				$this->Flash->set('ça marche',['class' => 'success']);
			}else{
				$this->Flash->set('ça marche pas',['class' => 'error']);
			}
			$this->request->redirect(['action'=>'index']);
		}
	}

	private function upload($slug = ''){
		$this->view->displayLayout = false;
		$media = [];
		$result = ['statu'=>false];
		if(!empty($slug)){
			$h = getallheaders();
			$dir =  PUBLIC_FOLDER.DS.'img'.DS.'upload'.DS.$slug;
			$source = file_get_contents('php://input');
			$fileName = $dir.DS.$h['X-File-Name'];
			if(!file_exists($fileName)){
				file_put_contents($fileName,$source);
				$media['type'] = $h['X-File-Type'];
				$media['name'] = $h['X-File-Name'];
				$media['size'] = $h['X-File-Size'];
				$media['url'] = '/img/upload/'.$slug.'/'.$media['name'] ;
				if($this->Post->addMedia($slug,$media)){
					$result['statu'] = true;
				}
			}else{
				$result['message'] = 'ce fichier exist deja : '.$h['X-File-Name'];
			}
		}
		$this->view->set(['result'=>$result,'media'=>$media]);
	}
}
