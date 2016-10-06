<?php $this->setTitle('Taxonomie'); ?>
<section>
	<header>
		<h1><?php echo _("Add Tag"); ?> </h1>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'add'])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'add a new tag','class'=>'legend-post'],
			'input'   => [
					'name' => ['label'=>'name'],
				]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>