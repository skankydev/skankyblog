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
use SkankyDev\Config\Config;


class ImageTool extends MasterTool {

	public $forma;
	public $jpegQuality;
	public $folder;

	function __construct(array $config){
		$this->forma = isset($config['forma'])? $config['forma'] : ['full' => ['width'=>1920 ,'height'=>1080]];
		$this->jpegQuality = isset($config['jpegQuality'])? $config['jpegQuality']: 100;
		$this->folder = isset($config['folder'])? $config['folder']: '';
	}

	public function setFolder(string $folder){
		$this->folder = $folder;
	}

	/**
	 * calculate different information to crop and resize images 
	 * @param  string $source image source
	 * @return bool         the result (true == it works)
	 */
	public function creatImages(string $source){
		$file = $this->folder.$source;
		$dimension = getimagesize($file);
		$oWidth  = $dimension[0];
		$oHeight = $dimension[1];
		$oRatio =$oWidth/$oHeight;
		$fileName = [];
		$fileName['origin'] = $source;
		foreach ($this->forma as $name => $size) {
			$dest = $this->folder.$name.'-'.$source;
			$fileName[$name] = $name.'-'.$source;
			$info = [];
			$info['dst_x'] = 0;
			$info['dst_y'] = 0;
			$dRation = $size['width']/$size['height'];
			$info['dst_w'] = $size['width'];
			$info['dst_h'] = $size['height'];
			if($oRatio == $dRation){
				$info['src_x'] = 0; 
				$info['src_y'] = 0;
				$info['src_w'] = $oWidth;
				$info['src_h'] = $oHeight;
			}else if($oRatio < $dRation){
				$pro = ($oHeight * $size['width'])/$oWidth;
				$step = ($pro - $size['height']);
				$info['src_x'] = 0; 
				$info['src_y'] = $step/2;
				$info['src_w'] = $oWidth;
				$info['src_h'] = ($size['height'] * ($oWidth))/$size['width'];
			}else if($oRatio > $dRation){
				$pro = ($oWidth * $size['height'])/$oHeight;
				$step = ($pro - $size['width']);
				$info['src_x'] = $step/2; 
				$info['src_y'] = 0;
				$info['src_w'] = ($size['width'] * ($oHeight))/$size['height'];
				$info['src_h'] = $oHeight;
			}
			$this->resize($this->folder.$source,$dest,$info);
		}
		return $fileName;

	}

	/**
	 * corp and resize a image
	 * 
	 * @param  string $source image source
	 * @param  string $dest   image destination
	 * @param  array  $info   information for corp and resize
	 *                         $info['dst_x'] : x-coordinate of destination point. 
	 *                         $info['dst_y'] : y-coordinate of destination point. 
	 *                         $info['src_x'] : x-coordinate of source point.
	 *                         $info['src_y'] : y-coordinate of source point. 
	 *                         $info['dst_w'] : Destination width. 
	 *                         $info['dst_h'] : Destination height. 
	 *                         $info['src_w'] : Source width.
	 *                         $info['src_h'] : Source height.
	 *                         for mor info see documentation
	 *                         http://php.net/manual/en/function.imagecopyresampled.php
	 * @return bool           success or not
	 * 
	 */
	function resize(string $source,string $dest,array $info){
			
		//crée une image temporaire
		$miniature = imagecreatetruecolor($info['dst_w'],$info['dst_h']);
		$ext = explode('.',$source);
		$ext = end($ext);
		$ext = strtolower($ext);
		if($ext==='jpeg'){$ext = 'jpg';}
		//selon le type de fichier
		switch ($ext) {
			case 'jpg':
				$image = imagecreatefromjpeg($source); 
			break;
			case 'png':
				$image = imagecreatefrompng($source); 
				imagealphablending( $miniature, false);
				imagesavealpha($miniature,true);
				imagealphablending($image, true);
				imagecolorallocatealpha($miniature,255,255,255,127);
			break;
			case 'gif':
				$image = imagecreatefromgif($source); 
			break;
			default:
				return false; 
			break;
		}
		//redimentionne l image
		imagecopyresampled($miniature,$image,$info['dst_x'] ,$info['dst_y'] ,$info['src_x'] ,$info['src_y'] ,$info['dst_w'] ,$info['dst_h'] ,$info['src_w'] ,$info['src_h']);

		$ext = explode('.',$dest);
		$ext = end($ext);
		$ext = strtolower($ext);
		if($ext==='jpeg'){$ext = 'jpg';}
		//creation du nouveau fichier
		switch ($ext) {
			case 'jpg':
				imagejpeg($miniature,$dest,$this->jpegQuality);
			break;
			case 'png':
				imagepng($miniature,$dest); 
			break;
			case 'gif':
				imagegif($miniature,$dest);
			break;
			default:
				return false; 
			break;
		}
		return true;
	}

}