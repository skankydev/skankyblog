<?php $this->setTitle('edit post'); ?>
<section>
	<header><h1>Edit Post</h1></header>
	<?php echo $this->Form->start($this->request->url(['action'=>'edit','params'=>['slug'=>$post->slug]])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'edite a post','class'=>'legend-post'],
			'input'   => [
					'_id'        => ['type' =>'hidden'],
					'name'       => ['label'=>'name'],
					'slug'       => ['label'=>'slug'],
					'content'    => ['label'=>'content','type'=>'Wysiwyg'],
					'tags'       => ['label'=>'tags','labelAttr'=>['class'=>'tags-label'],'type'=>'select','option'=>$tags,'multiple'=>'checkbox','attr'=>['class'=>'checkbox']],
					'online'     => ['label'=>'online','type'=>'checkbox'],
					'categories' => ['label'=>'category','type'=>'select','option'=>['','html','css','php','js','MongoDB'],'class'=>'post-select']
				]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer',['class'=>'btn-submit']); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>
<?php 
	$files = $this->Form->getScriptFile();
	foreach ($files as $file) {
		$this->addJs($file);
	}
?>
<?php $this->startScript(); ?>
	<?php echo $this->Form->getScript(); ?>
<?php $this->stopScript(); ?>
