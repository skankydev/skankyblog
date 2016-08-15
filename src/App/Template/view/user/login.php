<?php $this->setTitle(' - login'); ?>
<div class="layout-login">
	<section id="Login">
		<header><h1>Login</h1></header>
		<?php echo $this->Form->start($this->request->url()); ?>
		<section>
			<?php echo $this->Form->fieldset([
				'fieldset'=> ['class'=>'fieldset-user'],
				'input'   => [
						'username' => ['label'=>'login'],
						'password' => ['label'=>'password','type'=>'password'],
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
