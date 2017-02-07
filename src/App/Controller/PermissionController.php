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
use SkankyDev\Config\Config;
use SkankyDev\Factory;
use SkankyDev\Utilities\Traits\StringFacility;
use App\Model\Document\Permission;

class PermissionController extends MasterController {
	
	use StringFacility;

	private function index(){
		$roles = $this->Permission->find();
		$this->view->set(['roles'=>$roles]);
	}

	private function init(){
		$moduls = Config::getModuleList();
		$filesList = [];
		$model = [];
		$data = [];
		foreach ($moduls as $modul) {
			$folder = APP_FOLDER.DS.'src'.DS.$modul.DS.'Controller';
			$dirContent = scandir($folder);
			foreach ($dirContent as $files) {

				if(is_file($folder.DS.$files)){
					$class = $modul.'\\Controller\\'.str_replace('.php', '', $files);
					$cName = str_replace('Controller.php', '', $files);
					$actionFolder = APP_FOLDER.DS.'src'.DS.$modul.DS.'Template'.DS.'view'.DS.$this->toDash($cName);
					$actions = scandir($actionFolder);
					$object = Factory::load($class,[],false);
					foreach ($actions as $action) {
						if(is_file($actionFolder.DS.$action)){
							$aName = lcfirst($this->toCap(str_replace('.php', '', $action)));
							if(method_exists($object, $aName)){
								$method = new \ReflectionMethod($object,$aName);
								if($method->isProtected()){
									$data[$cName][$aName]= 'allow';
								}elseif($method->isPrivate()){
									$data[$cName][$aName]= 'deny';
								}
							}
						}
					}
				}
			}
		}
		$this->Permission->delete(['name'=>'init']);
		$perm = new \stdClass();
		$perm->name = 'init';
		$perm->action = $data;
		$perm = $this->Permission->createDocument($perm);
		$this->Permission->save($perm);
		$this->view->set(['perm'=>$perm]);
	}

	private function add(){
		if($this->request->isPost()){
			$role = $this->Permission->createDocument($this->request->getData());
			$init = $this->Permission->findOne(['name'=>'init']);
			$role->action = $init->action;
			if($this->Permission->isValid($role)){
				if($this->Permission->save($role)){
					$this->Flash->set('ca marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
					$this->request->data = $role;
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $role;
			}
		}
	}

	private function edit($name =''){
		$role = $this->Permission->findOne(['name'=>$name]);
		if($this->request->isPost()){
			$role =$this->Permission->createDocument($this->request->getData());
			if($this->Permission->isValid($role)){
				if($this->Permission->save($role)){
					$this->Flash->set('ca marche',['class' => 'success']);
					$this->request->redirect(['action'=>'index']);
				}else{
					$this->Flash->set('ca marche pas',['class' => 'error']);
					$this->request->data = $role;
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $role;
			}
		}
		$this->view->set(['role'=>$role]);
	}

	private function update(){
		$roles = $this->Permission->find();
		$init = $this->Permission->findOne(['name'=>'init']);
		$action = (array)$init->action;
		foreach ($roles as $role) {
			$actionList = (array)$role->action;
			foreach ($action as $key => $value) {
				if(isset($actionList[$key] )){
					$actionList[$key] = array_replace_recursive((array)$value,(array)$actionList[$key]);
				}else{
					$actionList[$key] = (array)$value;
				}
			}
			$role->action = $actionList;
			$this->Permission->save($role);
		}
		$this->view->set(['init'=>$init]);
	}
}
