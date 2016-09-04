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
					'content'    => ['label'=>'content','type'=>'textarea','rows'=>'8','cols'=>'50'],
					'tags'       => ['label'=>'tags','type'=>'select','option'=>['joli', 'test', 'machin','youpi','marche'],'multiple'=>'checkbox'],
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