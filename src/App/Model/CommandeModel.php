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

namespace App\Model;

use SkankyDev\Model\NoSqlModel;
use SkankyDev\Database\MongoClient;

class CommandeModel extends NoSqlModel {

	protected $behavior = [
		'Timed'
	];

	public function initValidator($validator){
	
	}

	public function install(){
		try {
			$client = MongoClient::getInstance();
			$option = [];
			$option['autoIndexId'] = true;
			$client->createCollection('commande',$option);
			$index = [];
			$index[0] = ['key'=>['num'=>1],'name'=>'num','unique'=>true];
			$client->createIndex('commande',$index);
			return 'CommandeModel: has been configured';			
		} catch (\MongoDB\Driver\Exception\RuntimeException $e) {
			return 'CommandeModel: '.$e->getMessage();
		}
	}

	public function create($cart,$profil,$user,$transport,$data){
		$option = $this->load('App\Model\OptionModel',true);
		$commande = $this->createDocument(new \stdClass());
		$commande->num = $option->getNexCommandeNum();

		$commande->clientName = $profil->civilite.' '.$profil->nom.' '.$profil->prenom;
		$commande->clientMail = $user->email;
		$commande->clientTel = $profil->telephone;
		$commande->adresse = $profil->adresse[$data->adresse];

		$commande->payment = false;
		$commande->prixTotal = 0;
		$commande->quantityTotal = 0;

		foreach ($cart as $key => $product) {
			$commande->product[]= $product;
			$commande->prixTotal += $product['total'];
			$commande->quantityTotal += $product['quantity'];
		}

		$prix = $transport->prix;
		if($transport->gratuit){
			$prix = ($commande->prixTotal<(float)$transport->gratuit)?$transport->prix:0;
		} 
		$port = [
			'ref'=> $transport->ref,
			'name'=> $transport->libelle,
			'prix'=> $prix,
			'quantity'=> 1,
			'total' => $prix,
		];
		$commande->product[] = $port;
		$commande->prixTotal += $prix;

		if($this->save($commande)){
			return $commande;
		}else{
			return false;
		}

	}

}
