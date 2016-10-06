<?php $this->setTitle('add post'); ?>
<section>
	<header><h1>Add Post</h1></header>
	<?php echo $this->Form->start($this->request->url(['action'=>'add'])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'creat a new post','class'=>'legend-post'],
			'input'   => [
					'name'       => ['label'=>'name'],
					'slug'       => ['label'=>'slug'],
					'content'    => ['label'=>'content','type'=>'Wysiwyg'],
					'tags'       => ['label'=>'tags','type'=>'select','option'=>$tags,'multiple'=>'checkbox'],
					'online'     => ['label'=>'online','type'=>'checkbox'],
					'categories' => ['label'=>'category','type'=>'select','option'=>['','html','css','php','js','MongoDB'],'class'=>'select-post']
			]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
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
