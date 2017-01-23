<?php 
namespace App\Model\Document;

use SkankyDev\Model\Document\MasterDocument;
use SkankyDev\Utilities\Traits\ArrayPathable;

class Permission extends MasterDocument {
	
	public $name;
	public $action;

}
