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
use SkankyDev\Utilities\Session;

class TestController extends MasterController {
	
	public function upload(){
		//petit exemple d upload qui marche
		if ($this->request->isPost()) {
			$files = $this->request->getFiles();
			if($files['img']['error']==UPLOAD_ERR_OK){
				$dir = PUBLIC_FOLDER.DS.'img'.DS.'uploads'.DS;
				if(!file_exists($dir)){
					mkdir($dir,0755,true);
				}
				$exv = ['jpg','jpeg','gif','png'];
				$ex = explode('.', $files['img']['name']);
				$ex = end($ex);
				if(in_array($ex, $exv)){//peux etre faire une limite de taille: && $files['img']['size'] < 3000000
					if(move_uploaded_file($files['img']['tmp_name'] , $dir.$files['img']['name'])){
						$this->Flash->set('ca marche',['class' => 'success']);
					}else{
						$this->Flash->set('ca marche pas',['class' => 'error']);
					}
				}
			}
		}
	}

	public function index(){
		$data = Session::get('skankydev.backlink');
		//Session::destroy();
		debug($data);
		
	}

}
