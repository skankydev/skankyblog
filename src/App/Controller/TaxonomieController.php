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

namespace App\Controller;

use SkankyDev\Controller\MasterController;

class TaxonomieController extends MasterController {
	
	private function index($page = 1,$field = 'name',$order = 1){

		$option = [
			'query'=>[],
			'page'=>(int)$page,
			'sort'=>[],
		];
		$option['sort'][$field] = (int)$order;
		$taxonomies = $this->Taxonomie->paginate($option);
		$this->Taxonomie->getList();
		$this->view->set(['taxonomies' => $taxonomies]);
	}

	private function add(){
		if($this->request->isPost()){
			$tag = $this->Taxonomie->createDocument($this->request->getData());
			$tag->slug = str_replace(' ', '-', $tag->name);
			$tag->count = 0;
			if($this->Taxonomie->isValid($tag)){
				if($this->Taxonomie->save($tag)){
					$this->Flash->set('ca marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
					$this->request->data = $tag;
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $tag;
			}
		}
	}
	
	private function edit($_id){
		$tag = $this->Taxonomie->findById($_id);
		if($this->request->isPost()){
			$tag = $this->Taxonomie->createDocument($this->request->getData());
			if($this->Taxonomie->isValid($tag)){
				if($this->Taxonomie->save($tag)){
					$this->Flash->set('ça marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ça marche pas',['class' => 'error']);
				}
			}else{
				$this->Flash->set('ça marche pas',['class' => 'warning']);
			}
		}
		$this->request->data = $tag;
		$this->view->set(['tag'=>$tag]);
	}
	
	private function delete($_id){
		if(!empty($_id)){
			if($this->Taxonomie->delete(['_id' => $_id])){
				$this->Flash->set('ca marche',['class' => 'success']);
			}else{
				$this->Flash->set('ca marche pas',['class' => 'error']);
			}
		}
		$this->request->redirect(['action'=>'index']);
	}

}