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
namespace SkankyTest\TestCase\Utilities\Traits;

use PHPUnit\Framework\TestCase;
use SkankyDev\Utilities\Traits\ArrayPathable;

class TestArray{
	use ArrayPathable;

	public $data;

	public function get($path = ''){
		return self::arrayGet($path,$this->data);
	}
	public function set($path,$value){
		return self::arraySet($path,$value,$this->data);
	}
	public function delete($path){
		return self::arrayDelete($path,$this->data);
	}
};


/**
 * @covers SkankyTest\TestCase\Utilities\Traits\TestArray
 * @coversDefaultClass SkankyTest\TestCase\Utilities\Traits\TestArray
 */
class ArrayPathableTest extends TestCase
{
	
	protected function setUp() {

		$this->myArray = new TestArray();
	}

	/**
	 * @covers ::set
	 */
	public function testSetInArray(){
		$this->myArray->set('coucou.test',10);
		$this->myArray->set('youpi','lala');
		$data = [
			'coucou'=>[
				'test'=>10
			],
			'youpi' => 'lala'
		];
		$this->assertArrayHasKey('youpi', $this->myArray->data);
		$this->assertEquals($data,$this->myArray->get());
		$this->assertEquals(false,$this->myArray->get('false'));
	}

	/**
	 * @covers ::get
	 */
	public function testGetInArray(){
		$this->myArray->set('coucou.test',10);
		$this->myArray->set('coucou.test2',20);
		$this->myArray->set('coucou.test2',30);//test update value
		$this->myArray->set('youpi','lala');

		$data = [
			'coucou'=>[
				'test'=>10,
				'test2'=>30,
			],
			'youpi' => 'lala'
		];

		
		$this->assertEquals(['test'=>10,'test2'=>30],$this->myArray->get('coucou'));
		$this->assertEquals(30,$this->myArray->get('coucou.test2'));
		$this->assertEquals($data,$this->myArray->get());
	}

	/**
	 * @covers ::delete
	 */
	public function testDeleteInArray(){
		$this->myArray->set('coucou.test',10);
		$this->myArray->set('coucou.test2',20);
		$this->myArray->set('youpi','lala');
		$data = [
			'coucou'=>[
				'test'=>10,
			],
			'youpi' => 'lala'
		];

		$this->myArray->delete('coucou.test2');
		$this->assertEquals($data,$this->myArray->get());
		$this->assertEquals(10,$this->myArray->get('coucou.test'));
		$this->assertEquals(null,$this->myArray->delete('coucou.youpi.test'));
	}



}