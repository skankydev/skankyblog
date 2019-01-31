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

namespace SkankyTest\TestCase\View;

use PHPUnit\Framework\TestCase;
use SkankyDev\View\ViewBuilder;

/**
 * @covers SkankyDev\View\ViewBuilder
 * @coversDefaultClass SkankyDev\View\ViewBuilder
 */
class ViewBuilderTest extends TestCase
{
	
	public function testSetDataForView(){
		$builder = new ViewBuilder();

		$exepted = ['post'=>['name'=>'title']];
		$builder->set('post',['name'=>'title']);
		$this->assertEquals($exepted,$builder->getData());

		$exepted['user'] = 'skankydev';
		$builder->set(['user'=>'skankydev']);
		$this->assertEquals($exepted,$builder->getData());
	}

	public function testAddHelper(){
		$builder = new ViewBuilder();

		$exepted = ['Flash'];
		$builder->addHelpers('Flash');
		$this->assertEquals($exepted,$builder->getHelpers());


		$exepted['Time'] = ['param'=>'param'];
		$builder->addHelpers(['Time'=>['param'=>'param']]);
		$this->assertEquals($exepted,$builder->getHelpers());

		$exepted[] = 'Auth';
		$builder->addHelpers(['Auth']);
		$this->assertEquals($exepted,$builder->getHelpers());
	}
	
}