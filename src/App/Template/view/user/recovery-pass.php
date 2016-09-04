<?php $this->setTitle('recovery password'); ?>
<div class="layout-login">
	<section id="Login">
		<header><h1><?php echo _("Forgot password"); ?></h1></header>
		<?php echo $this->Form->start($this->request->url(['controller'=>'user','action'=>'recoveryPass','params'=>['login'=>$user->login,'token'=>$user->verifToken->value]])); ?>
		<section>
			<?php echo $this->Form->fieldset([
				'fieldset'=> ['class'=>'fieldset-user'],
				'legend'  => ['content'=>$user->login.'<br>'.$user->email],
				'input'   => [
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
