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

class TransportController extends MasterController {
	
	private function index($page = 1,$field = 'ref',$order = 1){
		$option = [
			'query'=>[],
			'page'=>(int)$page,
			'sort'=>[],
		];
		$option['sort'][$field] = (int)$order;
		$transport = $this->Transport->paginate($option);
		$this->view->set(['transport' => $transport]);
	}

	private function add(){
		if($this->request->isPost()){
			$port = $this->Transport->createDocument($this->request->getData());
			if($this->Transport->isValid($port)){
				if($this->Transport->save($port)){
					$this->Flash->set('ca marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
					$this->request->data = $port;
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $port;
			}
		}
	}

	private function edit($ref=''){
		$port = $this->Transport->findOne(['ref'=>$ref]);
		if($this->request->isPost()){
			$port = $this->Transport->createDocument($this->request->getData());
			if($this->Transport->isValid($port)){
				if($this->Transport->save($port)){
					$this->Flash->set('ca marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
					$this->request->data = $port;
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $port;
			}
		}
		$this->request->data = $port;
		$this->view->set(['port'=>$port]);
	}

	private function delete($_id=''){
		if(!empty($_id)){
			if($this->Transport->delete(['_id' => $_id])){
				$this->Flash->set('ca marche',['class' => 'success']);
			}else{
				$this->Flash->set('ca marche pas',['class' => 'error']);
			}
		}
		$this->request->redirect(['action'=>'index']);
	}

}