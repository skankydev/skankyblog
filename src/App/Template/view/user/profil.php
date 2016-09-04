<?php $this->setTitle($user->login); ?>
<section id="User">
	<header><h1><?php echo $user->login; ?></h1></header>
	<hr>
	<section>
		<dl>
			<dt><?php echo _('e-mail'); ?></dt>
			<dd><?php echo $user->email; ?></dd>
			<dt><?php echo _('updated'); ?></dt>
			<dd><?php echo $this->Time->toHuman($user->updated); ?></dd>
			<dt><?php echo _('created'); ?></dt>
			<dd><?php echo $this->Time->toHuman($user->created); ?></dd>
			<dt><?php echo _('password'); ?></dt>
			<dd><?php echo $this->link('change', ['controller'=>'user','action'=>'changePass']);?></dd>
		</dl>
	</section>
	<footer></footer>
</section>