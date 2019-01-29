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

namespace SkankyTest\TestCase\Utilities;

use PHPUnit\Framework\TestCase;
use SkankyDev\Utilities\Validator;

/**
 * @covers SkankyDev\Utilities\Validator
 * @coversDefaultClass SkankyDev\Utilities\Validator
 */
class ValidatorTest extends TestCase
{

	public function testNotEmpty(){
		$validator = new Validator();
		$this->assertEquals(true,$validator->notEmpty('youpi'));
	}
	public function testRegex(){
		$validator = new Validator();
		$this->assertEquals(true,$validator->regex('youpi','/[a-z]*/'));
	}
	public function testMinLength(){
		$validator = new Validator();
		$this->assertEquals(true,$validator->minLength('youpi',3));
	}
	public function testMaxLength(){
		$validator = new Validator();
		$this->assertEquals(true,$validator->maxLength('youpi',8));
	}
	public function testBetweenLength(){
		$validator = new Validator();
		$this->assertEquals(true,$validator->betweenLength('youpi',3,8));
	}

	public function testIsEmail(){
		$validator = new Validator();
		$this->assertEquals(true,$validator->isEmail('youpi@skankydev.com'));
		$this->assertEquals(false,$validator->isEmail('youpi@skankydev'));
		$this->assertEquals(true,$validator->isEmail('you.pi@skankydev.com'));
	}

	public function testIsNum(){
		$validator = new Validator();
		$this->assertEquals(true,$validator->isNum(12));
	}

	public function testIsString(){
		$validator = new Validator();
		$this->assertEquals(true,$validator->isString('youpi'));
	}

	public function testIsBool(){
		$validator = new Validator();
		$this->assertEquals(false,$validator->isBool('youpi'));
	}

	/**
	 * @covers ::addRules
	 */
	public function testAddRules(){
		$validator = new Validator();
		$validator->addRules(['name'],['notEmpty'],'ne doit pas etre vide');
		$validator->addRules(['slug'],['notEmpty','regex'=>['preg'=>'/^[a-z0-9\-\']*$/']],'le slug doit être séparé par des \'-\' ');
		

		$exept = [
			'name'=>[
				'rules'=>['notEmpty'],
				'message'=>'ne doit pas etre vide',
			],
			'slug'=>[
				'rules'=>[
					'notEmpty',
					'regex'=>['preg'=>'/^[a-z0-9\-\']*$/']
				],
				'message'=>'le slug doit être séparé par des \'-\' '
			]
		];
		$this->assertEquals($exept,$validator->getRules());
		
		//je triture pour le fun mais ça doit pas etre utiliser comme ca 
		$validator->addRules(['name'],['minLength'=>[3]],'doit avoir au moin 3 char');
		$exept['name']['rules'] += ['minLength'=>[3]];
		$exept['name']['message'] = 'doit avoir au moin 3 char';

		//var_dump($exept);
		$this->assertEquals($exept,$validator->getRules());

		$validator->addRules('text',['notEmpty'],'ne doit pas etre vide');
		$exept['text'] = [
			'rules'=>['notEmpty'],
			'message'=>'ne doit pas etre vide',
		];
		$this->assertEquals($exept,$validator->getRules());

		$validator->addRules('text',['isString'],'ne doit pas etre vide');
		$exept['text']['rules'] += ['isString'];
		$this->assertEquals($exept,$validator->getRules());
	}

	public function testValidData(){
		$validator = new Validator();
		$validator->addRules(['name'],['notEmpty'],'ne doit pas etre vide');
		$validator->addRules(['slug'],['notEmpty','regex'=>['preg'=>'/^[a-z0-9\-\']*$/']],'le slug doit être séparé par des \'-\' ');
		$validator->addRules(['mail'],['isEmail'],'doit etre une adresse valid');
		$validator->trimTag(['name','slug']);

		$data = new \stdClass();
		$data->name = 'youpi test';
		$data->slug = 'youpi-test';
		$data->mail = 'youpi@test.com';
		$this->assertEquals(true,$validator->valid($data));

		$data = new \stdClass();
		$data->name = 'youpi test';
		$data->slug = 'youpi-test';
		$data->mail = 'youpi test';
		$this->assertEquals(false,$validator->valid($data));
		$this->assertEquals(['mail'=>'doit etre une adresse valid'],$data->messageValidate);

	}

	public function testTrimTag(){
		$validator = new Validator();
		$validator->trimTag(['name','slug']);

		$data = new \stdClass();
		$data->name = ' youpi test ';
		$data->slug = '<h1>youpi-test';

		$validator->doTrim($data);

		$this->assertEquals('youpi test',$data->name);
		$this->assertEquals('youpi-test',$data->slug);


	}

}