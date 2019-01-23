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
namespace App\View\Helper;

use SkankyDev\View\Helper\MasterHelper;
use SkankyDev\Utilities\UserAgent;
use SkankyDev\View\Helper\Htmlhelper;

class ImagesHelper extends MasterHelper {
	
	use HtmlHelper;

	var $asso = [
		'Mobile' => 'mini',
		'Tablet' => 'full',
		'Desktop' => 'full',
	];

	public function __construct($config = []){
		
	}

	public function imgDevice($media,$attr = []){
		$device = UserAgent::getInstance()->getDevice();
		$attribut = '';
		if(!empty($attr)){
			$attribut = $this->createAttr($attr);
		}
		$src = $media['url'];
		if(isset($media['deriver'])){
			$src .= $media['deriver'][$this->asso[$device]];
		}else{
			$src .= $media['name'];
		}
		return '<img src="'.$src.'" '.$attribut.'>';
	}

}
//<?php echo $slider->media['url'].$slider->media['name'];  " class="slider-img">
