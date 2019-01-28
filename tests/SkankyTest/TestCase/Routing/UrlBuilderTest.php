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
use SkankyDev\Routing\Route\Route;
use SkankyDev\Routing\Router;
use SkankyDev\Routing\UrlBuilder;



/**
 * @covers SkankyDev\Routing\UrlBuilder
 * @covers SkankyDev\Config\Config
 * @covers SkankyDev\Routing\Router
 * @covers SkankyDev\Routing\Route\Route
 * @covers SkankyDev\Routing\Route\CurrentRoute
 * @covers SkankyDev\Request
 * @coversDefaultClass SkankyDev\Routing\UrlBuilder
 */
class UrlBuilderTest extends TestCase
{
	//public function testBuildUrlFromDefaultRoute(){
	public function testAddCurentValueInLink(){
		Config::set('default.namespace','App');
		Config::set('default.action','index');
		Config::set('Module',['App','Cms']);
		$current = Router::_findCurrentRoute('/post/index');

		$this->assertEquals([
			'namespace'=>'App',
			'controller'=>'Post',
			'action'=>'add',
		], UrlBuilder::_completLink(['action'=>'add']));
	}

	public function testMatchingRoute(){
		Config::set('default.namespace','App');
		Config::set('default.action','index');
		Config::set('Module',['App','Cms']);

		Router::_add('/article/:slug',[
			'controller' => 'Post',
			'action'     => 'view'
		],[
			'slug'=>'[a-zA-Z0-9\-]*',
		]);

		$test = UrlBuilder::_matcheWithRoute([
			'namespace'=>'App',
			'controller'=>'Post',
			'action'=>'view'
		]);
		$this->assertInstanceOf(Route::class,$test);
		$this->assertEquals('/article/:slug',$test->getShema());

		$test = UrlBuilder::_matcheWithRoute([
			'namespace'=>'Cms',
			'controller'=>'Media',
			'action'=>'add'
		]);
		$this->assertEquals(null,$test);
	}

	public function testBuildFromMatchingRoute(){
		Config::set('default.namespace','App');
		Config::set('default.action','index');
		Config::set('Module',['App','Cms']);

		Router::_add('/article/:slug',[
			'controller' => 'Post',
			'action'     => 'view'
		],[
			'slug'=>'[a-zA-Z0-9\-]*',
		]);

		$test = UrlBuilder::_build(['controller'=>'Post','action'=>'view','params'=>['youpi-test']]);
		$this->assertEquals('/article/youpi-test',$test);

	}

	public function testBuildFromDefaultRoute(){
		Config::set('default.namespace','App');
		Config::set('default.action','index');
		Config::set('Module',['App','Cms']);

		$test = UrlBuilder::_build(['controller'=>'Message','action'=>'view','params'=>['youpi-test']]);
		$this->assertEquals('/message/view/youpi-test',$test);

		$test = UrlBuilder::_build(['namespace'=>'Cms','controller'=>'Message','action'=>'index','get'=>['page'=>1]]);
		$this->assertEquals('/cms/message?page=1',$test);

		$_SERVER['HTTP_HOST'] = 'dev.skankyblog.com';
		$_SERVER['REQUEST_SCHEME'] = 'http';
		$_SERVER['REQUEST_METHOD'] = 'get';
		$_SERVER['REQUEST_URI'] = '/';

		$test = UrlBuilder::_build(['controller'=>'Message'],true);
		$this->assertEquals('http://dev.skankyblog.com/message',$test);

	}

	public function testAddGetVarialbeInUrl(){
		$url = UrlBuilder::_addGet('/article/youpi-test', ['page'=>1,'order'=>'field']);
		$this->assertEquals('/article/youpi-test?page=1&order=field',$url);
	}

}