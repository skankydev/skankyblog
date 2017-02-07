<?php $this->setTitle('Product'); ?>
<section>
	<header>
		<h1> </h1>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'add']),['enctype'=>"multipart/form-data"]); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>''],
			'legend'  => ['content'=>'','class'=>''],
			'input'   => [
				'ref'         => ['label'=>'ref','type'=>'text'],
				'name'        => ['label'=>'name','type'=>'text'],
				'prix'        => ['label'=>'prix','type'=>'number','step'=>'0.01'],
				'media'       => ['label'=>'image','type'=>'file'],
				'description' => ['label'=>'description',
								'type'=>'Wysiwyg','construct'=>[
										'link'=>false,
										'color'=>true,
										'title'=>true,
									]
								],
				'online'      => ['label'=>'online','type'=>'checkbox'],
				'stock'       => ['label'=>'en stock','type'=>'checkbox'],
			]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>
