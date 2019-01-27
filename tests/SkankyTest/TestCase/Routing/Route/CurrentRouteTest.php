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
use SkankyDev\Routing\Route\CurrentRoute;
use SkankyDev\Config\Config;


/**
 * @covers SkankyDev\Routing\Route\CurrentRoute
 * @covers SkankyDev\Routing\Route\Route
 * @covers SkankyDev\Config\Config
 * @coversDefaultClass SkankyDev\Routing\CurrentRoute
 */

class CurrentRouteTest extends TestCase
{

	public function testGetControllerNameFromRoute(){
		Config::set('default.namespace','App');
		Config::set('default.action','index');
		$route = new Route('/',[
			'controller' => 'Home',
		]);
		$current = new CurrentRoute('/',$route);

		$this->assertEquals('App\Controller\HomeController', $current->getController());

		$route = new Route('/article/:slug/:id',[
			'controller' => 'Post',
			'action'     => 'view',
			'params'     => [
				'slug',
				'id'
			]
		],[
			'slug'=> '[a-zA-Z0-9\-]*',
			'id'  => '[0-9]*'
		]);
		$current = new CurrentRoute('/article/youpi-test/1',$route);
		$this->assertEquals('App\Controller\PostController', $current->getController());
		$this->assertEquals([
			'namespace' => 'App',
			'controller' => 'Post',
			'action' => 'view',
			'params'=>[
				'slug'=>'youpi-test',
				'id' => '1'
			]
		], $current->getLink());
	}

	public function testGetControllerNameFromUri(){
		Config::set('default.action','index');
		Config::set('default.namespace','App');
		Config::set('Module',['App','Cms']);
		$current = new CurrentRoute('/post',null);

		$this->assertEquals('App\Controller\PostController', $current->getController());
		$this->assertEquals([
			'namespace' => 'App',
			'controller' => 'Post',
			'action' => 'index',
		], $current->getLink());

		$current = new CurrentRoute('/post/edit/youpi-machin/42',null);
		$this->assertEquals([
			'namespace' => 'App',
			'controller' => 'Post',
			'action' => 'edit',
			'params'=>[
				'youpi-machin',
				'42'
			]
		], $current->getLink());

		$current = new CurrentRoute('/cms/post/edit/youpi-machin/42',null);
		$this->assertEquals(['youpi-machin','42'], $current->getParams());
		$this->assertEquals('edit', $current->getAction());
		$this->assertEquals('Cms', $current->getNamespace());
	}

}