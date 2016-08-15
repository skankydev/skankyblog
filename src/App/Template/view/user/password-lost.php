<div class="layout-login">
	<section id="Login">
		<header><h1>Forgot password</h1></header>
		<?php echo $this->Form->start($this->request->url()); ?>
		<section>
			<?php echo $this->Form->fieldset([
				'fieldset'=> ['class'=>'fieldset-user'],
				'input'   => [
						'email'    => ['label'=>'E-mail','type'=>'email'],
					]
			]); ?>
		</section>
		<footer>
			<?php echo $this->Form->submit('Envoyer'); ?>
		</footer>
		<?php echo $this->Form->end(); ?>
	</section>
</div>
