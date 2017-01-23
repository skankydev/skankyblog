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
namespace SkankyDev\View;

use SkankyDev\request;
use SkankyDev\View\MasterView;
use SkankyDev\Config\Config;
use SkankyDev\View\Helper\HtmlHelper;
use SkankyDev\Router;

class HtmlView extends MasterView {
	
	use HtmlHelper;

	public $helpers = ['Form','Flash','Auth','Time'];

	public $keywords = '';
	public $title = '';
	public $meta = [];
	public $css = '';
	public $js = '';

	function __construct(){
		$this->request = Request::getInstance();
	}

	/**
	 * add css file for header
	 * @param string $path the path to the file
	 */
	public function addCss($path){
		$this->css .= '<link href="'.$path.'" rel="stylesheet" type="text/css">'.PHP_EOL;
	}

	/**
	 * add js file for header
	 * @param string $path the path to the file
	 */
	public function addJs($path){
		$this->js .= '<script type="text/javascript" src="'.$path.'" ></script>'.PHP_EOL;
	}

	/**
	 * get header option 
	 * @return string html header option
	 */
	public function getHeader(){
		$this->getFileFromHelper();
		$retour = '';
		$retour .= '<meta name="keywords" content="'.$this->keywords.'" />'.PHP_EOL;
		foreach ($this->meta as $name => $content) {
			$retour .= '<meta name="'.$name.'" content="'.$content.'" />'.PHP_EOL;
		}
		$retour .= $this->css;
		$retour .= $this->js;
		return $retour;
	}

	/**
	 * start the buffuring view for script in end of the page
	 * @return void
	 */
	public function startScript(){
		ob_start();
	}
	
	/**
	 * stop the buffuring for script
	 * @return void
	 */
	public function stopScript(){
		$this->script .= ob_get_clean();
	}

	/**
	 * get the script 
	 * @return string the script
	 */
	public function getScript(){
		$retour = '';
		$retour .= $this->getScriptFromHelper();
		$retour .= $this->script;
		return $retour;
	}

	/**
	 * TO DO a revoir !
	 * [elementFromView description]
	 * @param  [type] $link [description]
	 * @return [type]       [description]
	 */
	public function elementFromView($link){
		$friend = Router::getInstance()->getElement($link);
		if($friend){
			$viewFolder = $this->toDash($link['controller']);
			$action = $this->toDash($link['action']);
			$friend->viewPath = Config::viewDir().DS.$viewFolder.DS.$action.'.php';

			//$friend->loadHelper();

			extract($friend->data);
			ob_start();
			require($friend->viewPath);
			$content = ob_get_clean();
			//$friend->getFileFromHelper();
			$this->script .= $friend->script;
			$this->css    .= $friend->css;
			$this->js     .= $friend->js;
			return $content;

		}else{
			$element = Config::getAccessDenied();
			if($element){
				return $this->element($element);
			}
		}	
		return false;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getTitle(){
		return $this->title;
	}

	public function addKeyWords($words){
		$this->keywords .= $words;
	}

	public function addMeta($name,$content){
		$this->meta[$name] = $content;
	}

	public function getFileFromHelper(){
		foreach ($this->helpers as $helper) {
			$scripts = $this->{$helper}->getScriptFile();
			foreach ($scripts as $script) {
				$this->addJs($script);
			}
			$cssFiles = $this->{$helper}->getCssFile();
			foreach ($cssFiles as $css) {
				$this->addCss($css);
			}
		}
	}

	public function getScriptFromHelper(){
		$retour = '';
		foreach ($this->helpers as $helper) {
			$retour .= $this->{$helper}->getScript();
		}
		return $retour;
	}
}
