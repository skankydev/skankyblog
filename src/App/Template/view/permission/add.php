<?php $this->setTitle('Permission'); ?>
<section>
	<header>
		<h1><?php echo _("Ajouter un role"); ?> </h1>
	</header>
	<?php echo $this->Form->start($role); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'add a new role','class'=>'legend-post'],
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