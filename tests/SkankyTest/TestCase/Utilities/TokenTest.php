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
use SkankyDev\Utilities\Token;

/**
 * @covers SkankyDev\Utilities\Token
 * @coversDefaultClass SkankyDev\Utilities\Token
 */
class TokenTest extends TestCase
{


	protected function setUp() {

		//$this->token = new Token();
	}

	/**
	 * @covers ::__construct
	 */
	public function testCreateToken(){
		$token = new Token();
		$this->assertObjectHasAttribute('value', $token);
		$this->assertObjectHasAttribute('time', $token);
	}
	
	/**
	 * @covers ::checkValue
	 */
	public function testCorrectValue(){
		$token = new Token();
		$this->assertEquals(true, $token->checkValue($token->value));
		$this->assertEquals(false, $token->checkValue('ceci nes pas valide'));
	}

	/**
	 * @covers ::checkTime
	 */
	public function testStileAlive(){
		$token = new Token();
		$this->assertEquals(true, $token->checkTime(3600));
		$this->assertEquals(false, $token->checkTime(-1));
	}

}