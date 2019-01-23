<?php $this->setTitle('titre'); ?>
<section>
	<header>
		<h1><?php echo $menu->name; ?> </h1>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'edit','params'=>['name'=>$menu->name]])); ?>
	<section>
	<?php echo $this->Form->fieldset([
		'input'   => [
			'_id'  => ['type' =>'hidden'],
			'name' => ['label'=>'name','type'=>'text']
		]
	]); ?>
	</section>
	<a class="btn-default add-entree"><?php echo _('nouvel entrée'); ?></a>
	<section class="link-list">
<?php $i = 0 ?>
<?php if (isset($menu->data)): ?>
	<?php foreach ($menu->data as $key => $data): ?>
	<div class="link">
		
		<label >text</label><input value="<?php echo isset($data->text)?$data->text:''; ?>" name="data[<?php echo $i ?>][text]"  type="text">
		<label >url</label><input value="<?php echo isset($data->url)?$data->url:''; ?>" name="data[<?php echo $i ?>][url]"  type="text">
		<hr><h4>OR</h4><hr>
		<label >controller</label><input value="<?php echo isset($data->link->controller)?$data->link->controller:''; ?>" name="data[<?php echo $i ?>][link][controller]"  type="text">
		<label >action</label><input value="<?php echo isset($data->link->action)?$data->link->action:''; ?>" name="data[<?php echo $i ?>][link][action]"  type="text">
		<?php $numParam = count($data->link->params)?>
		<?php foreach ($data->link->params as $k => $v): ?>
		<label >params</label><input value="<?php echo $v; ?>" name="data[<?php echo $i ?>][link][params][<?php echo $k ?>]" type="text">
		<?php endforeach ?>
		<a class="btn-default add-param" data-num="<?php echo $numParam ?>" data-count="<?php echo $i ?>">add param</a>
		<a class="btn-error link-remove"><i class="fa fa-trash " aria-hidden="true"></i></a>
	</div>
	<?php $i++; ?>
	<?php endforeach ?>
<?php endif ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('save'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>

<?php $this->startScript(); ?>
<script type="text/javascript">
$(document).ready(function(){
	var count = <?php echo $i; ?>;

	function getText(){
		var text = '';
		text += '<div class="link">';
		text += '<label >text</label>';
		text += '<input value="" name="data['+count+'][text]"  type="text">';
		text += '<label >url</label>';
		text += '<input value="" name="data['+count+'][url]"  type="text">';
		text += '<hr><h4>OR</h4><hr>';
		text += '<label >controller</label>';
		text += '<input value="" name="data['+count+'][link][controller]"  type="text">';
		text += '<label >action</label>';
		text += '<input value="" name="data['+count+'][link][action]"  type="text">';
		text += '<label >params</label>';
		text += '<input value="" name="data['+count+'][link][params][0]" type="text">';
		text += '<a class="btn-default add-param" data-num="1" data-count="'+count+'">add param</a>';
		text += '<a class="btn-error link-remove"><i class="fa fa-trash " aria-hidden="true"></i></a>';
		text += '</div>';
		count +=1;
		return text;
	}
	
	$('.add-entree').on('click',function(e){
		var html = getText();
		$('.link-list').append(html);
	});

	$('.link-list').on('click','.link-remove',function(e){
		$(this).parent().remove();
	});

	$('.link-list').on('click','.add-param',function(e){
		var num = $(this).attr('data-num');
		var c = $(this).attr('data-count');
		num = parseInt(num);
		c = parseInt(c);
		var html = '<label for="params-0">params</label>';
		html += '<input value="" name="data['+c+'][link][params]['+num+']" id="params-'+num+'" type="text">';
		num += 1;
		$(this).attr('data-num',num);
		$(this).before(html);
	});
});
</script>
<?php $this->stopScript(); ?>