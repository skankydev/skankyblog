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

class MenuController extends MasterController {

	public function view($name){
		$menu = $this->Menu->findMenu($name);
		$this->view->set(['menu'=>$menu]);
	}
	
	private function index(){
		$menus = $this->Menu->find();
		$this->view->set(['menus'=>$menus]);
	}

	private function add(){
		if($this->request->isPost()){
			$menu = $this->Menu->createDocument($this->request->getData());
			if($this->Menu->isValid($menu)){
				if($this->Menu->save($menu)){
					$this->Flash->set('ca marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
					$this->request->data = $menu;
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $menu;
			}
		}
	}

	private function edit($name){
		$menu = $this->Menu->findOne(['name'=>$name]);
		if($this->request->isPost()){
			$menu = $this->Menu->createDocument($this->request->getData());
			if($this->Menu->isValid($menu)){
				if($this->Menu->save($menu)){
					$this->Flash->set('ca marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
			}
		}
		$this->request->data = $menu;
		$this->view->set(['menu'=>$menu]);
	}
	
	private function delete($_id){

	}

}
