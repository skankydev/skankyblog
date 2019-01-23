<?php $this->setTitle(_('Menu')); ?>
<section>
	<header>
		<h1><?php echo _('Menu'); ?></h1>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'add'])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'new menu','class'=>'legend-post'],
			'input'   => [
				'name' => ['label'=>'name','type'=>'text']
			]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>
