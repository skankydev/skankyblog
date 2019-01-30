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

namespace SkankyTest\TestCase\Config;

use PHPUnit\Framework\TestCase;
use SkankyDev\Config\Config;

/**
 * @covers SkankyDev\Config\Config
 * @coversDefaultClass SkankyDev\Config\Config
 */
class ConfigTest extends TestCase
{

	public function testInitConfig(){
		$baspath = dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR.'data';
		$conf = Config::initConf($baspath);
		$this->assertEquals(true, is_array($conf) );
	}

	public function testGetInfoFromConfig(){
		$this->assertEquals('1.0.0',Config::getVersion());
		$this->assertEquals(false,Config::getAccessDenied());

		Config::setCurentNamespace('Cms');
	}

	public function testArrayMergeIsCorrect(){
		$this->assertEquals([
			'Size'    => 'App\View\Helper\SizeHelper',
			'Sociaux' => 'App\View\Helper\SociauxHelper',
			'Images'  => 'App\View\Helper\ImagesHelper',			
			'Flash'   => 'SkankyDev\View\Helper\FlashMessagesHelper',
			'Form'    => 'SkankyDev\View\Helper\FormHelper',
			'Auth'    => 'SkankyDev\View\Helper\AuthHelper',
			'Time'    => 'SkankyDev\View\Helper\TimeHelper',		
		],Config::getHelper());		
	}

	public function testCurrentNamspaceIsChange(){
		$this->assertEquals('Cms',Config::getCurentNamespace());
		Config::setCurentNamespace('App');
	}
}
