<?php $this->setTitle(_('Frais de port')); ?>
<section>
	<header>
		<h1><?php echo _('Frais de port'); ?></h1>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'edit','params'=>['ref'=>$port->ref]])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>''],
			'legend'  => ['content'=>'','class'=>''],
			'input'   => [
				'_id'     => ['type' =>'hidden'],
				'ref'     => ['label'=>'ref','type'=>'text'],
				'libelle' => ['label'=>'libelle','type'=>'text'],
				'prix'    => ['label'=>'prix','type'=>'number'],
				'gratuit' => ['label'=>'gratuit a partire de','type'=>'number'],
			]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>

