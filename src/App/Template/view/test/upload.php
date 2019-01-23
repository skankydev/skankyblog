<?php $this->setTitle('upload'); ?>
<section>
	<header>
		<h1> </h1>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'index']),['enctype'=>"multipart/form-data"]); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>''],
			'legend'  => ['content'=>'','class'=>''],
			'input'   => [
				'img' => ['label'=>'un fichier svp','type'=>'file'],
				'text' => ['label'=>'un text svp','type'=>'text']
			]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>
