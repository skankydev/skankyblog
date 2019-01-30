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

namespace SkankyTest\TestCase\View\Helper;

use PHPUnit\Framework\TestCase;
use SkankyDev\Config\Config;
use SkankyDev\Request;
use SkankyDev\View\Helper\FormHelper;

/**
 * @covers SkankyDev\View\Helper\FormHelper
 * @coversDefaultClass SkankyDev\View\Helper\FormHelper
 */
class FormHelperTest extends TestCase
{
	
	public function setUp(){
		Config::set('form.class',[
			'div'      => 'field',
			'input'    => 'field-input',
			'label'    => 'field-label',
			'textarea' => 'field-textarea',
			'button'   => 'btn-submit'
		]);
		Config::set('class.formElement',[]);

		$_SERVER['HTTP_HOST'] = 'dev.skankyblog.com';
		$_SERVER['REQUEST_SCHEME'] = 'http';
		$_SERVER['REQUEST_METHOD'] = 'get';
		$_SERVER['REQUEST_URI'] = '/';

		$request = Request::getInstance();
		var_dump($request);
		$request->namespace = 'App';
		$request->controller = 'Post';
		$request->action = 'add';

	}


	public function testCreateFormHelper(){
		$helper = new FormHelper();
		$this->assertInstanceOf(FormHelper::class,$helper);
	}
}