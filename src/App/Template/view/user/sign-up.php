<?php $this->setTitle(' - Sign Up'); ?>
<div class="layout-login">
	<section id="Login">
		<header><h1><?php echo _('Sign Up'); ?></h1></header>
		<?php echo $this->Form->start($this->request->url(['action'=>'signUp'])); ?>
		<section>
			<?php echo $this->Form->fieldset([
				'fieldset'=> ['class'=>'fieldset-user'],
				'legend'  => ['content'=>'creat a new user','class'=>'legend-user'],
				'input'   => [
						'email'    => ['label'=>'E-mail','type'=>'email'],
						'login'    => ['label'=>'login'],
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
</div>