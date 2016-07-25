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

class InstallController extends MasterController {
	
	public function index(){
		$moduls = Config::getModuleList();
		$filesList = [];
		$model = [];
		$message = [];
		foreach ($moduls as $modul) {
			$folder = APP_FOLDER.DS.'src'.DS.$modul.DS.'Model';
			$dirContent = scandir($folder);
			foreach ($dirContent as $files) {
				
				if(is_file($folder.DS.$files)){
					$class = $modul.'\\Model\\'.str_replace('.php', '', $files);
					$collection = str_replace('Model.php', '', $files);
					$object = Factory::load($class,['name'=>$collection],false);
					if(method_exists($object, 'install')){
						$message[] = $object->install();
					}
					$model[] = ['class'=>$class, 'collection'=>$collection];

				}
			}
		}
		$this->view->set( ['modul' => $moduls,'model' => $model, 'message'=>$message] );
	}

}
