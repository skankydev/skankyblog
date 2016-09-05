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
		//c'est mon tour ?
		$option = [
			'limit'=> 5,
			'query'=> [],
			'sort' => ['updated'=> -1],
			'page'=>(int)$page,
		];
		$posts = $this->Post->paginate($option);
		$this->view->set( ['posts' => $posts] );
	}

	public function view($slug=''){
		$post = $this->Post->findBySlug($slug);
		$this->view->set(['post' => $post]);
	}

	private function add(){
		if($this->request->isPost()){

			$post = $this->Post->createDocument($this->request->data);
			$post->slug = str_replace(' ', '-', $post->name);
			if($this->Post->isValid($post)){
				if($this->Post->save($post)){
					$this->Flash->set('ca marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
					$this->request->data = $post;
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $post;
			}
		}
	}

	private function edit($slug = ''){

		$post = $this->Post->findBySlug($slug);
		if($this->request->isPost()){
			$post = $this->Post->createDocument($this->request->data);
			if($this->Post->isValid($post)){
				if($this->Post->save($post)){
					$this->Flash->set('ca marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
				}
			}else{
				$this->Flash->set('ca marche pas',['class' => 'warning']);
			}
		}
		$this->request->data = $post;
		$this->view->set(['post' => $post]);
	}

	private function delete($slug = ''){
		if(!empty($slug)){
			if($this->Post->delete(['slug' => $slug])){
				$this->Flash->set('ca marche',['class' => 'success']);
			}else{
				$this->Flash->set('ca marche pas',['class' => 'error']);
			}
			$this->request->redirect(['action'=>'index']);
		}
	}

}
