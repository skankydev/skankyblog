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
use SkankyDev\Request;

class WysiwygElement extends MasterElement {
	
	private $config = [
		'img' => false,
		'link' => false,
		'title' => false,
		'color' => false,
	];

	function __construct(&$form , $option = []){
		$this->form = $form;
		$this->option = array_replace($this->config, $option);
		$this->request = Request::getInstance();
	}


	function input($name,$attr = [],$value = ''){
		$this->setScript($name);
		ob_start();
		?>
<div id="WysiwygToolbar" style="display: none;">
	<a class="btn-wysiwyg-bold" data-wysihtml-command="bold" title="CTRL+B">B</a>
	<a class="btn-wysiwyg-italic" data-wysihtml-command="italic" title="CTRL+I">I</a>
	<?php if ($this->option['color']): ?>
		<div class="btn-wysiwyg-color" >color</div>
	<?php endif ?>
	<span class="wysiwyg-separator"></span>
	<?php if ($this->option['title']): ?>
		<a class="btn-wysiwyg-title" data-wysihtml-command="formatBlock" data-wysihtml-command-value="h2">T1</a>
		<a class="btn-wysiwyg-title" data-wysihtml-command="formatBlock" data-wysihtml-command-value="h3">T2</a>
		<span class="wysiwyg-separator"></span>		
	<?php endif ?>
	<a class="btn-wysiwyg-undo" data-wysihtml-command="undo" title="undo">&#10558;</a>
	<a class="btn-wysiwyg-redo" data-wysihtml-command="redo" title="redo">&#10559;</a>
	<span class="wysiwyg-separator"></span>
	<?php if ($this->option['link']): ?>
		<a class="btn-wysiwyg-link" data-wysihtml-command="createLink" title="link">&#128279;</a>
	<?php endif ?>
	<?php if ($this->option['img']): ?>
		<a class="btn-wysiwyg-img" data-wysihtml-command="insertImage" title="insert image">&#128444;</a> 
	<?php endif ?>
	<span class="empty-space"></span>
	<a class="btn-wysiwyg-source" data-wysihtml-action="change_view">&#60;/&#62;</a>
	<?php if ($this->option['link']): ?>
		<div class="wysiwyg-box" data-wysihtml-dialog="createLink" style="display: none;">
			<label class="wysiwyg-label-a">
				Link:
				<input class="wysiwyg-input-a" data-wysihtml-dialog-field="href">
			</label>
			<a class="btn-wysiwyg success" data-wysihtml-dialog-action="save">&#10004;</a>
			<a class="btn-wysiwyg error" data-wysihtml-dialog-action="cancel">&#10008;</a>
		</div>		
	<?php endif ?>

	<?php if ($this->option['img']): ?>
		<div class="wysiwyg-box" data-wysihtml-dialog="insertImage" style="display: none;">
			<?php if (is_array($this->option['img'])): ?>
				<div class="wysiwyg-upload">
					<input id="input-img" name="files[]" multiple="" type="file">
					<ul class="upload-list">
						
					</ul>
					<a class='btn-default upload-img'>upload</a>
				</div>
				<ul class="list-img">
					<?php foreach ($this->option['img']['media'] as $media): ?>
					<li class="img-elem">
						<img class="img-select" src="<?php echo $media['url']; ?>" data-name="<?php echo $media['name']; ?>" data-size="<?php echo $media['size']; ?>" data-type="<?php echo $media['type']; ?>">
						<span class="img-name"><?php echo $media['name']; ?></span>
					</li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>

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
	<?php endif ?>


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
			editor.composer.commands.exec("setColor",val);
		}
	});
<?php if (is_array($this->option['img'])): ?>
	var fileList = [];
	$('#input-img').on('change',function(e){
		//console.log(e.target.files);
		list = e.target.files;
		for (var i = 0; i < e.target.files.length; i++) {
			if(e.target.files[i].size<=5242880){
				var type = e.target.files[i].type;
				if(type.startsWith('image')){
					$('.upload-list').append('<li>'+e.target.files[i].name+'</li>');
					fileList.push(e.target.files[i]);
				}else{
					alert(e.target.files[i].name + ' n\'est pas une image');
				}
			}else{
				alert(e.target.files[i].name + ' est trop volumineux');
			}
		}
		console.log(fileList);//  5242880
	});
	$(".upload-img").on('click',function(e){
		$('.upload-list').html('');
		upload(fileList,$(this),0);
	});//list-img
	$('.list-img').on('click','.img-select',function(e){
		console.log($(this));
		var link = $(this).attr('src');
		$('.wysiwyg-input-a').val(link);
	});
	function upload(files,area,index){
		var xhr = new XMLHttpRequest();
		var file = files[index];
		xhr.upload.onprogress = function(e){
			console.log(e.loaded);
			console.log(e.total);
		};

		xhr.onload = function(e){
			console.log('upload complete');
			console.log(e);
			var retour = jQuery.parseJSON(e.target.responseText);
			if(retour.statu){
				$('.list-img').append(retour.html);
				if(index < files.length-1){
					upload(files,area,index+1);
				}else{
					fileList = [];
				}
			}else{
				alert(retour.message);
			}
		};
		xhr.open('POST', <?php echo '\''.$this->option['img']['uploadLink'].'\'' ?>);
		xhr.setRequestHeader('conten-type','multipart/form-data');
		xhr.setRequestHeader('X-File-Type',file.type);
		xhr.setRequestHeader('X-File-Size',file.size);
		xhr.setRequestHeader('X-File-Name',file.name);
		xhr.setRequestHeader('X-Param-Token',<?php echo '\''.$this->form->token->value.'\'' ?>);
		xhr.send(file);		
	}

<?php endif ?>


});

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



