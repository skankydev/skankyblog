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
use SkankyDev\Utilities\Paginator;

/**
 * @covers SkankyDev\Utilities\Paginator
 * @coversDefaultClass SkankyDev\Utilities\Paginator
 */
class PaginatorTest extends TestCase
{
	public function testPaginatorGetInfo(){
		$data = [
			0 => 'test0',
			1 => 'test1',
			2 => 'test2',
			3 => 'test3',
			4 => 'test4',
			5 => 'test5',
			6 => 'test6',
			7 => 'test7',
			8 => 'test8',
			9 => 'test9',
			10 => 'test10',
		];
		$option = [
			'limit' => 10,
			'page' => 1,
			'count' => 184,
			'range' => 5,
			'sort' => ['slug' => 1]
		];

		$paginator =  new Paginator($data,$option);
		$this->assertEquals([
			'sort' => ['slug' => 1],
			'limit' => 10,
			'page' => 1,
			'count' => 184,
			'range' => 5,
			'pages' => 19,
			'first' => 1,
			'last' => 19,
			'next' => 2,
			'prev' => 1,
			'start' => 1,
			'stop' => 4,
		],$paginator->getOption());
	}


	/**
	 * dataProvider sortProvider
	 */
	public function testPaginatorSortPagarms(){
		$data = [
			0 => 'test0',
			1 => 'test1',
			2 => 'test2',
			3 => 'test3',
			4 => 'test4',
			5 => 'test5',
			6 => 'test6',
			7 => 'test7',
			8 => 'test8',
			9 => 'test9',
			10 => 'test10',
		];
		
		$option = [
			'limit' => 10,
			'page' => 1,
			'count' => 184,
			'range' => 5,
			'sort' => ['slug' => 1]
		];
		$paginator =  new Paginator($data,$option);
		$this->assertEquals([
			'page' => 1,
			'field' => 'slug',
			'order' => -1,
		],$paginator->sortParams('slug'));
		$this->assertEquals([
			'page' => 1,
			'field' => 'title',
			'order' => 1,
		],$paginator->sortParams('title'));
	}

}