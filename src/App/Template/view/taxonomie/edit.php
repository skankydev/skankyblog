<?php $this->setTitle('Taxonomie'); ?>
<section>
	<header>
		<h1><?= _("Edit Tag"); ?> </h1>
	</header>
	<?= $this->Form->start($this->request->url(['action'=>'edit','params'=>[$tag->_id]])); ?>
	<section>
		<?= $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'edit a new tag','class'=>'legend-post'],
			'input'   => [
					'_id' => ['type'=>'hidden'],
					'name' => ['label'=>'name'],
				]
		]); ?>
	</section>
	<footer>
		<?= $this->Form->submit('Envoyer'); ?>
	</footer>
	<?= $this->Form->end(); ?>
</section>