<?php $this->setTitle('add post'); ?>
<section id='Post'>
	<header><h1>Add Post</h1></header>
	<?= $this->Form->start($post); ?>
	<section>
		<?= $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'creat a new post','class'=>'legend-post'],
			'input'   => [
				'name'       => ['label'=>'name'],
				'slug'       => ['label'=>'slug'],
				'content'    => [
					'label'     => 'content',
					'type'      => 'Wysiwyg',
					'construct' => [
							'link'  => false,
							'color' => true,
							'title' => true,
						]
					],
				'tags'       => ['label'=>'tags','type'=>'select','option'=>$tags,'multiple'=>'checkbox'],
				'online'     => ['label'=>'online','type'=>'checkbox'],
				'categories' => [
					'label' => 'category',
					'type'  => 'select',
					'option'=> ['','html','css','php','js','MongoDB'],
					'class' => 'select-post'
				]
			]
		]); ?>
	</section>
	<footer>
		<?= $this->Form->submit('Envoyer'); ?>
	</footer>
	<?= $this->Form->end(); ?>
</section>
