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
use SkankyDev\Utilities\Traits\StringFacility;

class TestString{
	use StringFacility;

};


/**
 * @covers SkankyTest\TestCase\Utilities\Traits\TestString
 * @coversDefaultClass SkankyTest\TestCase\Utilities\Traits\TestString
 */
class StringFacilityTest extends TestCase
{
	
	protected function setUp() {

		$this->myFacility = new TestString();
	}

	public function testStringToDash(){
		$string = 'infoActionName';
		$this->assertEquals('info-action-name', $this->myFacility->toDash($string));
		$this->assertEquals('info_action_name', $this->myFacility->toDash($string,'_'));
		$this->assertEquals('info.action.name', $this->myFacility->toDash($string,'.'));
	}
	
	public function testStringToCap(){
		$string = 'info-action-name';
		$this->assertEquals('InfoActionName', $this->myFacility->toCap($string));
		$string = 'info_action_name';
		$this->assertEquals('InfoActionName', $this->myFacility->toCap($string,'_'));
		$string = 'info.action.name';
		$this->assertEquals('InfoActionName', $this->myFacility->toCap($string,'.'));
	}

	public function testStringToCamel(){
		$string = 'info-action-name';
		$this->assertEquals('infoActionName', $this->myFacility->toCamel($string));
		$string = 'info_action_name';
		$this->assertEquals('infoActionName', $this->myFacility->toCamel($string,'_'));
		$string = 'info.action.name';
		$this->assertEquals('infoActionName', $this->myFacility->toCamel($string,'.'));

	}
	public function testStringCleanString(){
		$string = 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ';
		$this->assertEquals('AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiieooooouuuuyy', $this->myFacility->cleanString($string));
		$string = 'ñomDéFîchìèr<bizar>.txt';
		$this->assertEquals('nomDeFichierbizar.txt', $this->myFacility->cleanString($string));
	}

}