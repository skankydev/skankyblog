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

namespace SkankyTest\TestCase\Routing;

use PHPUnit\Framework\TestCase;
use SkankyDev\Config\Config;
use SkankyDev\Routing\Route\CurrentRoute;
use SkankyDev\Routing\Route\Route;
use SkankyDev\Routing\Router;

/**
 * @covers SkankyDev\Routing\Router
 * @covers SkankyDev\Config\Config
 * @covers SkankyDev\Routing\Route\Route
 * @covers SkankyDev\Routing\Route\CurrentRoute
 * @coversDefaultClass SkankyDev\Routing\Router
 */
class RouterTest extends TestCase
{
	
	public function testAddRouteInRouter(){
		Config::set('default.namespace','App');
		Config::set('default.action','index');
		Router::_add('/',[
			'controller' => 'Home',
			'action'     => 'index'
		]);
		$this->assertCount(1, Router::_getRoutesCollection());
		
	}

	public function testMatcheRouteInRoutesCollection(){
		Config::set('default.namespace','App');
		Config::set('default.action','index');
		Router::_add('/',[
			'controller' => 'Home',
			'action'     => 'index',
		]);
		Router::_add('/article/:slug',[
			'controller' => 'post',
			'action'     => 'view',
			'params'     => [
				'slug',
			]
		],[
			'slug'=>'[a-zA-Z0-9\-]*',
		]);
		$route = Router::_matchRouteUri('/');
		$this->assertInstanceOf(Route::class,$route);
		$this->assertEquals('/',$route->getShema());
		
		$route = Router::_matchRouteUri('/article/youpi-test');
		$this->assertInstanceOf(Route::class,$route);
		$this->assertEquals('/article/:slug',$route->getShema());
		
		$route = Router::_matchRouteUri('/post/add');
		$this->assertEquals(null,$route);
	}

	public function testFindCurentRoute(){
		Config::set('default.namespace','App');
		Config::set('default.action','index');
		Router::_add('/',[
			'controller' => 'Home',
			'action'     => 'index',
		]);
		Router::_add('/article/:slug',[
			'controller' => 'post',
			'action'     => 'view',
			'params'     => [
				'slug',
			]
		],[
			'slug'=>'[a-zA-Z0-9\-]*',
		]);
		$current = Router::_findCurrentRoute('/');
		$this->assertInstanceOf(CurrentRoute::class,$current);
			
		$current = Router::_findCurrentRoute('/post/add');
		$this->assertInstanceOf(CurrentRoute::class,$current);
		$this->assertEquals('App\Controller\PostController',$current->getController());

		$test = Router::_getCurrentRoute();
		$this->assertEquals($current->getLink(),$test->getLink());
		
	}
}