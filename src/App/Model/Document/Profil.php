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

namespace App\Model\Document;

use SkankyDev\Model\Document\MasterDocument;
use SkankyDev\Utilities\Traits\StringFacility;

class Profil extends MasterDocument {

	public $civilite;
	public $nom;
	public $prenom;
	public $adresse;
	public $telephone;
	public $mobil;
	public $user_email;

	public function getFullName(){
		return ucfirst($this->civilite.' '.$this->nom.' '.$this->prenom);
	}


}
