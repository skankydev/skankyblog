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
use SkankyDev\Utilities\UserAgent;

/**
 * @covers SkankyDev\Utilities\UserAgent
 * @coversDefaultClass SkankyDev\Utilities\UserAgent
 */
class UserAgentTest extends TestCase
{

	public function TestUserAgentConstruct(){
		$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:64.0) Gecko/20100101 Firefox/64.0';
		$agent = UserAgent::getIstance();

		$this->assertEquals('Windows',$agent->os);
		$this->assertEquals('Firefox',$agent->browser);
		$this->assertEquals(false,$agent->mobile);
	}

	/**
     * @dataProvider userAgentProvider
     */
	public function testUserAgentParser($agent,$os,$browser,$mobile){
		$parsed = UserAgent::_parse($agent);
		$this->assertEquals($os,$parsed['os']);
		$this->assertEquals($browser,$parsed['browser']);
		$this->assertEquals($mobile,$parsed['mobile']);
		$device = $mobile?'Mobile':'Desktop';
		$this->assertEquals($device,UserAgent::_getDevice());
	}

	public function userAgentProvider(){
		return[[
			'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:64.0) Gecko/20100101 Firefox/64.0',
			'Windows','Firefox',false
		],[
			'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36',
			'Windows','Chrome',false
		],[
			'Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.34 (KHTML, like Gecko) Version/11.0 Mobile/15A5341f Safari/604.1',
			'iOS','Safari',true
		],[
			'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36',
			'Linux','Chrome',false
		],[
			'Mozilla/5.0 (Linux; Android 7.0; Moto G (4) Build/NPJS25.93-14-18) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36',
			'Android','Chrome',true
		],[
			'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3153.0 Safari/537.36 OPR/48.0.2664.0',
			'MacOS','Opera',false
		],[
			'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0',
			'Ubuntu','Firefox',false
		]];
	}
}