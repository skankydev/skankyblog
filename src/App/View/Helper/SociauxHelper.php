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
use SkankyDev\Request;

class SociauxHelper extends MasterHelper {
	
	function __construct(){
		
	}

	public function google(){
		ob_start();
		?>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'fr'}
</script>
		<?php 
		$script = ob_get_clean();
		$this->addScript($script);
		return '<div class="g-plusone" data-annotation="none"></div>';
	}

	public function facebook(){
		$url = Request::getCurentUrl();
		ob_start();
		?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
		<?php 
		$script = ob_get_clean();
		$this->addScript($script);
		$retour = '';
		$retour .='<div class="fb-like" data-href="'.$url.'" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>';
		return $retour;
	}

	public function all(){
		$retour = '<div><ul class="sociaux">';
		$retour .= '<li>'.$this->google().'</li>';
		$retour .= '<li>'.$this->facebook().'</li>';
		$retour .= '<ul></div>';
		return $retour;
	}

}