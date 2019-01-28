<?php $this->setTitle($post->name); ?>
<section id='Post'>
	<header><h1><?php echo $post->name; ?></h1>
		<?php echo $this->link('Edit Post',['action'=>'edit', 'params'=>['sulg'=>$post->slug]],['class'=>'btn-warning']); ?>
	</header>
	<section><?php echo $post->content; ?></section>
	<div class="clear"></div>
	<footer>
		<?php if (isset($post->tags)): ?>
			<div class='tags'>
			<?php foreach ($post->tags as $tag): ?>
				<span class="legend"><?php echo $tag; ?></span>
			<?php endforeach ?>
			</div>				
		<?php endif ?>
	</footer>
</section>
<section id="Message">
<?php
//$post_id = $post->_id->__toString();
//echo $this->elementFromView(['namespace'=>'App','controller'=>'Message','action'=>'add','params'=>['posts_id'=>$post_id]]);
//echo $this->elementFromView(['namespace'=>'App','controller'=>'Message','action'=>'index','params'=>['page'=>1,'posts_id'=>$post_id]]);
?>
</section>

<?php $this->startScript() ?>
<script type="text/javascript">
$(document).ready(function(){
	var post_id = '<?php echo $post->_id ?>';
	var curentPage = 1;

	$('#Message-Form').on('click','button[type="submit"]',function(event){
		event.stopPropagation();
		var me = $(event.delegateTarget);
		var form = $(me).find('form');
		var data = form.formToObject();
		$.post(form.prop('action'),data,function(html){
			me.html(html);
			me.initForm();
			test = me.find('.success');
			if(test.length){
				$.get(<?php echo '"'.$this->request->url(['controller'=>'message','action'=>'index','params'=>['page'=>1,'post_id'=>$post->_id]]).'"'; ?>,function(html){
					$('#Message-List').html(html);
					curentPage = 1; //ca c'est la solution 
				});
			}
			return false;
		});
		return false;
	});

	$('.btn-see-more').on('click',function(event){
		var link = <?php echo '"'.$this->request->url(['controller'=>'message','action'=>'index']).'"'; ?>;
		curentPage += 1;
		link += '/'+curentPage+'/'+post_id;
		$.get(link,function(html){
			//ro c'est null !
			//ta bo avoir tout changer ca bug toujours 
			$('#Message-List').append(html);
			//effacer le bouton ca serais cool aussi 
		});
	});

});
</script>
<?php $this->stopScript() ?>