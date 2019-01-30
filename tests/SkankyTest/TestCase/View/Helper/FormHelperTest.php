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
use SkankyDev\Request;
use SkankyDev\View\Helper\FormHelper;
use SkankyTest\Fixtures\InitConfigFixture;



/**
 * @covers SkankyDev\View\Helper\FormHelper
 * @covers SkankyDev\Config\Config
 * @covers SkankyDev\Request
 * @coversDefaultClass SkankyDev\View\Helper\FormHelper
 */
class FormHelperTest extends TestCase
{
	
	public function setUp(){

		InitConfigFixture::init();

		/*Config::set('form.class',[
			'div'      => 'field',
			'input'    => 'field-input',
			'label'    => 'field-label',
			'textarea' => 'field-textarea',
			'button'   => 'btn-submit'
		]);
		Config::set('class.formElement',[]);*/

		$_SERVER['HTTP_HOST'] = 'dev.skankyblog.com';
		$_SERVER['REQUEST_SCHEME'] = 'http';
		$_SERVER['REQUEST_METHOD'] = 'get';
		$_SERVER['REQUEST_URI'] = '/';

		$request = Request::getInstance();
		//var_dump($request);
		$request->namespace = 'App';
		$request->controller = 'Post';
		$request->action = 'add';

	}


	public function testCreateFormHelper(){
		$helper = new FormHelper();
		$this->assertInstanceOf(FormHelper::class,$helper);
	}

	public function testGetLabel(){
		$helper = new FormHelper();

		$this->assertEquals('<label class="field-label" >Label</label>',$helper->label('Label'));
	}

	public function testFieldSet(){
		$helper = new FormHelper();

		$result = $helper->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'add a new tag','class'=>'legend-post'],
			'input'   => [
					'name' => ['label'=>'name'],
				]
		]);
		$exepte = '<fieldset class="fieldset-post" ><legend class="legend-post" >add a new tag</legend><div class="field text" ><label for="name" class="field-label" >name</label><input type="text" value="" name="name" id="name" class="field-input"  ></div></fieldset>';
		$this->assertEquals($exepte,$result);
	}
}
