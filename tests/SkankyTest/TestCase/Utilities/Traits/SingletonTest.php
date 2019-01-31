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
use SkankyDev\Utilities\Traits\Singleton;
use SkankyDev\Exception\UnknownMethodExeption;

class MyTestSingleton{

	public $id;

	use Singleton;


	public function __construct(){
		$this->id = uniqid();
	}

	public function getId(){
		return $this->id;
	}
};


/**
 * @covers SkankyTest\TestCase\Utilities\Traits\MyTestSingleton
 * @coversDefaultClass SkankyTest\TestCase\Utilities\Traits\MyTestSingleton
 */
class SingletonTest extends TestCase
{

	public function testSingletonCallStatique(){
		$singleton = MyTestSingleton::_getId();
		$this->assertEquals(MyTestSingleton::getInstance()->getId(),$singleton);
	}

	public function testSingletonIsSingle(){
		$singleton = MyTestSingleton::getInstance();
		$this->assertEquals(MyTestSingleton::getInstance()->getId(),$singleton->getId());
	}

	/**
	 * @expectedException SkankyDev\Exception\UnknownMethodException
	 */
	public function testMethodDontExsiste(){
		$this->expectException(MyTestSingleton::_unknown());
	}
}