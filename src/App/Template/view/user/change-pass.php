<?php $this->setTitle('change password'); ?>
<div class="layout-login">
	<section id="Login">
		<header><h1><?php echo _("Change password"); ?></h1></header>
		<?php echo $this->Form->start($this->request->url(['controller'=>'user','action'=>'changePass'])); ?>
		<section>
			<?php echo $this->Form->fieldset([
				'fieldset'=> ['class'=>'fieldset-user'],
				'input'   => [
						'password' => ['label'=>'password','type'=>'password','required'=>'required'],
						'new'      => ['label'=>'new password','type'=>'password','required'=>'required'],
						'confirme' => ['label'=>'confirmer password','type'=>'password','required'=>'required'],
					]
			]); ?>
		</section>
		<footer>
			<?php echo $this->Form->submit('Envoyer'); ?>
		</footer>
		<?php echo $this->Form->end(); ?>
	</section>
</div>
