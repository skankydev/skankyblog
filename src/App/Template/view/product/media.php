<?php $this->setTitle('Media'); ?>
<section>
	<header>
		<h1><?php echo $product->ref.' : '.$product->name ?></h1>
	</header>
	<section>
	<input id="input-img" name="files[]" multiple="" type="file">
	<ul class="upload-list">
	
	</ul>
	<a class='btn-default upload-img'>upload</a>
	<ul class="list-img">
		<?php foreach ($product->media as $key=>$media): ?>
		<li class="img-elem">
			<img class="img-select" src="<?php echo $media['url']; ?>" >
			<span><?php echo $media['name']; ?></span>
			<span>
			<?php echo $this->link('<i class="fa fa-trash " aria-hidden="true"></i>',
				['controller'=>'product','action'=>'deleteMedia','params'=>['ref'=>$product->ref,'key'=>$key]],['class'=>'btn-error']);?>
			</span>
		</li>
		<?php endforeach ?>
	</ul>
	</section>
	<footer>
		
	</footer>
</section>
 <?php $this->startScript(); ?>
<script type="text/javascript">
$(document).ready(function(){
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
		upload(fileList,$('.list-img'),0);
	});

	function upload(files,area,index){
		var xhr = new XMLHttpRequest();
		var file = files[index];
		
		xhr.onload = function(e){
			console.log('upload complete');
			console.log(e);
			var retour = jQuery.parseJSON(e.target.responseText);
			if(retour.statu){
				area.append(retour.html);
				if(index < files.length-1){
					upload(files,area,index+1);
				}else{
					fileList = [];
				}
			}else{
				alert(retour.message);
			}
		};
		xhr.open('POST', <?php echo '\''.$this->request->url(['action'=>'addMedia','params'=>['ref'=>$product->ref]]).'\'' ?>);
		xhr.setRequestHeader('conten-type','multipart/form-data');
		xhr.setRequestHeader('X-File-Type',file.type);
		xhr.setRequestHeader('X-File-Size',file.size);
		xhr.setRequestHeader('X-File-Name',file.name);
		xhr.setRequestHeader('X-Param-Token',<?php echo '\''.$token->value.'\'' ?>);
		xhr.send(file);		
	}
});
</script>
<?php $this->stopScript(); ?>
