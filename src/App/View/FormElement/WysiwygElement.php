<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */

namespace App\View\FormElement;

use SkankyDev\View\FormElement\MasterElement;


class WysiwygElement extends MasterElement {
	
	private $default;

	function __construct(&$form , $option = []){
		$this->form = $form;
		$this->option = $option;
		//debug($this->option);
	}

	/*function __invock($name,$attr){
		return 'coucou wysiwyg';
	}*/

	function input($name,$attr = [],$value = ''){
		$this->setScript($name);
		ob_start();
		?>
<div id="WysiwygToolbar" style="display: none;">
	<a class="btn-wysiwyg-bold" data-wysihtml-command="bold" title="CTRL+B">B</a>
	<a class="btn-wysiwyg-italic" data-wysihtml-command="italic" title="CTRL+I">I</a>
	<div class="btn-wysiwyg-color" >color</div>
	<span class="wysiwyg-separator"></span>
	<a class="btn-wysiwyg-title" data-wysihtml-command="formatBlock" data-wysihtml-command-value="h2">T1</a>
	<a class="btn-wysiwyg-title" data-wysihtml-command="formatBlock" data-wysihtml-command-value="h3">T2</a>
	<span class="wysiwyg-separator"></span>
	<a class="btn-wysiwyg-undo" data-wysihtml-command="undo" title="undo">&#10558;</a>
	<a class="btn-wysiwyg-redo" data-wysihtml-command="redo" title="redo">&#10559;</a>
	<span class="wysiwyg-separator"></span>
	<a class="btn-wysiwyg-link" data-wysihtml-command="createLink" title="link">&#128279;</a>
	<a class="btn-wysiwyg-img" data-wysihtml-command="insertImage" title="insert image">&#128444;</a> 
	<span class="empty-space"></span>
	<a class="btn-wysiwyg-source" data-wysihtml-action="change_view">&#60;/&#62;</a>

	<div class="wysiwyg-box" data-wysihtml-dialog="createLink" style="display: none;">
		<label class="wysiwyg-label-a">
			Link:
			<input class="wysiwyg-input-a" data-wysihtml-dialog-field="href">
		</label>
		<a class="btn-wysiwyg success" data-wysihtml-dialog-action="save">&#10004;</a>
		<a class="btn-wysiwyg error" data-wysihtml-dialog-action="cancel">&#10008;</a>
	</div>

	<div class="wysiwyg-box" data-wysihtml-dialog="insertImage" style="display: none;">
		<label class="wysiwyg-label-a">
			Image: <br>
			<input class="wysiwyg-input-a" data-wysihtml-dialog-field="src">
		</label>
		<label class="wysiwyg-label-a">
			Align:
			<select data-wysihtml-dialog-field="className">
				<option value="post-img-default">default</option>
				<option value="post-img-left">left</option>
				<option value="post-img-right">right</option>
			</select>
		</label><br>
		<a class="btn-wysiwyg success" data-wysihtml-dialog-action="save" title="ok">&#10004;</a>
		<a class="btn-wysiwyg error" data-wysihtml-dialog-action="cancel" title="cancel">&#10008;</a>
	</div>

</div>
<textarea id="<?php echo $name ?>" name="<?php echo $name ?>" ><?php echo $value ?></textarea>
		<?php
		$content = ob_get_clean();
		//debug($content);
		return $content;
	}

	function setScript($name){
		ob_start();
		?>
<script type="text/javascript">
$(document).ready(function(){

	wysihtml.commands.setColor = (function() {
		var REG_EXP = /text-color-[0-9a-z]+/g;

		return {
			exec: function(composer, command, color) {
				wysihtml.commands.formatInline.exec(composer, command, {className: "text-color-" + color, classRegExp: REG_EXP, toggle: true});
			},

			state: function(composer, command, color) {
				console.log('state');
				return wysihtml.commands.formatInline.state(composer, command, {className: "text-color-" + color});
			}
		};
	})();
	
	var editor = new wysihtml.Editor("<?php echo $name ?>", {
		toolbar:        "WysiwygToolbar",
		parserRules:    wysihtmlParserRules,
		useLineBreaks:  true,
		stylesheets: "/css/editor.css"
	});

	$('.btn-wysiwyg-color').colorSelect({
		outPut:function(val){
			console.log(val);
			editor.composer.commands.exec("setColor",val);
		}
	});

})
</script>
		<?php
		$script = ob_get_clean();
		$this->form->addScript($script);
		$this->form->addScriptFile('/vendor/wysihtml/wysihtml.js');
		$this->form->addScriptFile('/vendor/wysihtml/wysihtml.all-commands.js');
		$this->form->addScriptFile('/vendor/wysihtml/wysihtml.toolbar.js');
		$this->form->addScriptFile('/vendor/wysihtml/simple.js');
	}


}



