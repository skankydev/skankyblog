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
namespace App\Model\Behavior;

use SkankyDev\Model\Behavior\MasterBehavior;
use SkankyDev\Auth;

class OwnerBehavior extends MasterBehavior {


	public function beforeInsert($data,$entity=null){
		//debug($data);die();
		$auth = Auth::getInstance()->getAuth();
		$data->author = $auth->username;
	}

	public function afterInsert($data,$entity=null){

	}

	public function beforeUpdate($data,$entity=null){

	}

	public function afterUpdate($data,$entity=null){

	}

	public function beforeCreateEntity($data,$entity=null){

	}

	public function afterCreateEntity($data,$entity=null){
		if(isset($data->author)){
			$entity->author = $data->author;
		}
	}

}
