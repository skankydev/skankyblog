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
use SkankyDev\Utilities\Traits\IterableData;

class MyTestIterable{

	public $data;

	use IterableData;


	public function __construct(){
		$this->data  = [
			0 => 'test0',
			1 => 'test1',
		];
	}
};


/**
 * @covers SkankyTest\TestCase\Utilities\Traits\MyTestIterable
 * @coversDefaultClass SkankyTest\TestCase\Utilities\Traits\MyTestIterable
 */
class IterableDataTest extends TestCase
{
	public function testIterableData(){
		$iterable = new MyTestIterable();
		
		$iterable->rewind();
		$this->assertEquals(true,$iterable->valid());
		$this->assertEquals('test0',$iterable->current());
		$this->assertEquals(0,$iterable->key());

		$this->assertEquals('test1',$iterable->next());
		$this->assertEquals(1,$iterable->key());
	
		$this->assertEquals(null,$iterable->next());
		$this->assertEquals(false,$iterable->valid());
	}

}