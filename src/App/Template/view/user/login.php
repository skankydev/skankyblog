<?php $this->setTitle('login'); ?>
<div class="layout-login">
	<section id="Login">
		<header><h1><?php echo _("Sign in"); ?></h1></header>
		<?php echo $this->Form->start(); ?>
		<section>
			<?php echo $this->Form->fieldset([
				'fieldset'=> ['class'=>'fieldset-user'],
				'input'   => [
						'email'    => ['label'=>'e-mail','type'=>'email'],
						'password' => ['label'=>'password','type'=>'password'],
						'remember' => ['label'=>'Remember me','type'=>'checkbox'],
					]
			]); ?>
		</section>
		<footer>
			<?php echo $this->Form->submit('Envoyer'); ?>
		</footer>
		<?php echo $this->Form->end(); ?>
		<section>
			<?php echo $this->link('Sign up', ['controller'=>'user','action'=>'signUp']);?> - 
			<?php echo $this->link('Forgot password', ['controller'=>'user','action'=>'passwordLost']);?>

		</section>
	</section>
</div>
