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
namespace App;

use SkankyDev\Auth;
use SkankyDev\Utilities\Interfaces\PermissionInterface;
use SkankyDev\Controller\Tools\FlashMessagesTool;

class PermissionManager implements PermissionInterface{
	
	public function __construct(){
		$this->Flash = new FlashMessagesTool();
	}

	function checkPublicAccess($link){
		return true;
	}

	function checkProtectedAccess($link){
		return $this->checkAccess($link);
	}
	
	function checkPrivateAccess($link){
		return $this->checkAccess($link);
	}

	public function checkAccess($link){
		return true;
		
		$perm = Auth::getPermission();
		$allow = false;
		if(isset($perm->action[$link['controller']][$link['action']])){
			$result = $perm->action[$link['controller']][$link['action']];
			$allow = ($result==='allow');
		}
		return $allow;
	}

}
