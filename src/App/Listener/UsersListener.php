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

namespace App\Listener;

use SkankyDev\Listener\MasterListener;

class UsersListener extends MasterListener {
	
	public function __construct(){

	}

	public function infoEvent(){
		return [
			'users.login'=>'trucdeouf',
			'collection.query.find' => 'newFind'
		];
	}

	public function trucdeouf($subject){
		//debug('trucdeouf');
	}

	public function newFind($subject){
		//debug(get_class($this));
	}
}
