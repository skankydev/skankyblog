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

namespace App\Controller\Tools;

use SkankyDev\Controller\Tools\MasterTool;
use SkankyDev\Request;
use SkankyDev\Config\Config;
use SkankyDev\View\Helper\HtmlHelper;
use SkankyDev\Utilities\Traits\StringFacility;
use SkankyDev\Controller\Tools\FlashMessagesTool;

class UploadTool extends MasterTool {
	
	use HtmlHelper;
	use StringFacility;

	public $folder;
	public $allow;
	public $url;

	public function __construct($config = []){
		//$this->conf = $config;
		

		if(isset($config['allow'])&&!empty($config['allow'])){
			$this->allow = $config['allow'];
		}else{
			$this->allow = Config::get('upload.image');
		}
		if(!isset($config['folder'])){
			$config['folder'] = Config::get('upload.folder');
		}
		$this->folder = PUBLIC_FOLDER.DS.$config['folder'];
		$this->url = str_replace(DS, '/', DS.$config['folder']);
	}

	public function createFolder($dir){
		$dir = $this->cleanString($dir);
		if(!file_exists($dir)){
			mkdir($dir,0755,true);
		}
	}

	public function upload($field, $folder = false ){
		$files = Request::getInstance()->getFiles($field);
		if(!$files){
			return false;
		}
		//debug($_FILES);
		$dir = $this->folder;
		$url = $this->url;
		if($folder){
			$dir .= $folder;
			$url .= str_replace(DS, '/', $folder);
		}
		$this->createFolder($dir);
		if(array_key_exists('name', $files)){
			$files = [0 => $files];
		}
		$retour = [];
		$this->Flash = new FlashMessagesTool();
		foreach ($files as $file) {
			if( !$file['error']){
				$tmp = [];
				$ex = explode('.', $file['name']);
				$ex = end($ex);
				if(in_array($ex, Config::get('upload.image'))){
					$ex = strtolower($ex);
					$name = $this->cleanString($file['name']);
					if(move_uploaded_file($file['tmp_name'] , $dir.$name)){
						$tmp['name'] = $name;
						$tmp['type'] = $ex;
						$tmp['folder'] = $dir;
						$tmp['url'] = $url;
						$tmp['size'] = $file['size'];
						$retour[] = $tmp;
					}else{
						$this->Flash->message(_('The file can not be upload: ').$file['name'],['class'=>'error']);
					}
				}else{
					$this->Flash->message(_('The file type is not supported: ').$file['name'],['class'=>'error']);
				}
			}else{
				$this->Flash->message(_('The selected file could not be upload: ').$file['name'],['class'=>'error']);
			}
		}
		return $retour;
	}
}
