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

namespace SkankyTest\TestCase\Routing\Route;

use PHPUnit\Framework\TestCase;
use SkankyDev\Routing\Route\Route;
use SkankyDev\Config\Config;


/**
 * @covers SkankyDev\Routing\Route\Route
 * @covers SkankyDev\Config\Config
 * @coversDefaultClass SkankyDev\Routing\Route
 */

class RouteTest extends TestCase
{
	public function testCreatRoute(){
		Config::set('default.namespace','App');
		$route = new Route('/',[
			'controller' => 'Home',
			'action'     => 'index'
		]);
		$this->assertEquals('/', $route->getShema());
		$this->assertEquals([
			'controller' => 'Home',
			'action'     => 'index',
			'namespace'  => 'App'
		],$route->getLink());
	}


	public function testCreateRoutWithMatcheRules(){
		Config::set('default.namespace','App');
		$route = new Route('/article/:slug',[
			'controller' => 'post',
			'action'     => 'view',
			'params'     => [
				'slug'
			]
		],['slug'=>'[a-zA-Z0-9\-]*']);
		$this->assertEquals('/^\/article\/[a-zA-Z0-9\-]*$/', $route->getMatcheRules());
	}
}