<section>
	<header><h1>Add User</h1></header>
	<?php echo $this->Form->start($this->request->url(['action'=>'add'])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-user'],
			'legend'  => ['content'=>'creat a new user','class'=>'legend-user'],
			'input'   => [
					'email'    => ['label'=>'E-mail','type'=>'email'],
					'username' => ['label'=>'login'],
					'password' => ['label'=>'password','type'=>'password'],
					'confirme' => ['label'=>'confirmer password','type'=>'password'],
				]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>
