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

namespace SkankyDev\Listener;


use SkankyDev\Listener\MasterListener;



class DebugListener extends MasterListener{

	public $files = []; 
	public $object = [];
	public $find = [];
	public $insert = [];
	public $update = [];
	public $first = false;

	public function __construct(){
	
	}

	public function infoEvent(){
		return [
			'factory.load'          => 'addfile',
			'auth.firstStep'        => 'firstStep',
			'auth.construct'        => 'newObject',
			'request.construct'     => 'newObject',
			'router.construct'      => 'newObject',
			'router.execute.before' => 'executeMain',
			'router.execute.after'  => 'executeMain',
			'router.element.before' => 'executeElement',
			'router.element.after'  => 'executeElement',
			'controller.construct'  => 'newObject',
			'model.construct'       => 'newObject',
			'model.query.insert'    => 'newInser',
			'model.query.update'    => 'newUpdate',
			'model.query.find'      => 'newQuery',
			'model.query.findOne'   => 'newQuery',
			'model.query.findById'  => 'newQuery',
			'model.query.count'     => 'newCount',
			'model.query.delete'    => 'newDelete',
			'view.render.before'    => 'beforeRender',
			'view.construct'        => 'newObject',
		];
	}
	public function newObject($subject){
		$this->object[] = get_class($subject);
	}

	public function beforeRender($subject){
		$this->message[]='render';
	}

	public function firstStep($subject){
		$this->first = true;
	}
	
	public function executeMain($subject){
		$this->message[]='i do somthing';
	}
	public function executeElement($subject){
		$this->message[]='i do somthing';
	}
	public function addfile($subject,$file){
		$this->files[] = $file;
	}

	public function newQuery($subject,$query){
		$this->query[] = $query;
	}

	public function newInser($subject,$document){
		$this->insert[] = $document;
	}

	public function newUpdate($subject,$document){
		$this->update[] = $document;
	}

	public function newCount($subject,$query){
		$this->count[] = $query;
	}

	public function newDelete($subject,$query){
		$this->delete[] = $query;
	}

}
