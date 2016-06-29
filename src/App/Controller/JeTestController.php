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

use SkankyDev\Auth;
use SkankyDev\Utilities\Session;
use SkankyDev\MasterController;
use SkankyDev\MasterModel;
use SkankyDev\Config\Config;

class JeTestController extends MasterController{

	public $tools = [
		'Flash','Mail'
	];

	public function index(){

		debug(Config::get('smtp.default'));

		$model = MasterModel::load('Task');
		$result= $model->find();
		
		if($this->request->isPost()){
			debug($this->request->data);
			$doc = $model->createDocument($this->request->data);
			if ($model->isValid($doc)) {
				$model->save($doc);
				$this->Flash->set('valide',['class' => 'success']);
			}else{
				$this->request->data = $doc;
				$this->Flash->set('pas valide',['class' => 'error']);
			}
		}
		$this->view->set(['result'=>$result]);
	}


	public function test(){
		//$to,$subject,$template,$var = []
		$this->Mail->creatMail('simon.schenck@gmail.com','test mail','test',['message'=>'j ai un message pour vous']);
		$this->Mail->attachment(APP_FOLDER.DS."public".DS.'img'.DS.'Luisaile.jpg');
		$this->Mail->sendMail();
	}
}
