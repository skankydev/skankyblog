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

/**
* 
*/
class MessageController extends MasterController {

	public function index($page = 1,$post_id=''){
		$this->view->displayLayout = false;
		$option = [
			'page'=>(int)$page,
			'limit'=>5,
			'sort' => ['created' => (int)-1 ]
		];
		if(!empty($post_id)){
			$post_id = $this->Message->createId($post_id);
			$option['query'] = ['post_id'=> $post_id];
		}
		$vue['messages'] = $this->Message->paginate($option);
		$this->view->set($vue);
	}
	
	public function view($id){
		$this->view->displayLayout = false;
		$message = $this->Message->findById($id);
		$this->view->set(['message' => $message]);
	}

	protected function add($post_id){
		$this->view->displayLayout = false;
		if($this->request->isPost()){
			$message = $this->Message->createDocument($this->request->data);
			if($this->Message->isValid($message)){
				if($this->Message->save($message)){
					$this->Flash->set('ca marche',['class' => 'success']);
					unset($this->request->data);
					$this->request->data = new \stdClass();
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $message;
			}
		}
		$this->view->set(['post_id'=>$post_id]);
	}

	protected function edit($_id){
		$this->view->displayLayout = false;
		$message = $this->Message->findById($_id);
		if(!isset($message->_id)){
			throw new \Exception("page not found", 404);
		}
		if($this->request->isPost()){

			if($message->isValid($this->request->data)){
				if($this->Message->save($message)){
					$this->Flash->set('ca marche',['class' => 'success']);
					//$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
				}
			}else{
				$this->Flash->set('ca marche pas',['class' => 'warning']);
			}
		}
		$this->request->data = $message;
		$this->view->set(['message' => $message]);
	}
}