<?php $this->setTitle($user->login); ?>
<section>

	<header><h1><?php echo $user->login; ?></h1></header>
	<hr>
	<section>
		<?php echo $this->Form->start($this->request->url(['action'=>'view','params'=>['login'=>$user->login]])); ?>
		<dl>
			<dt><?php echo _('e-mail'); ?></dt>
			<dd><?php echo $user->email; ?></dd>
			<dt><?php echo _('login'); ?></dt>
			<dd><?php echo $user->login; ?></dd>
			<dt><?php echo _('valide'); ?></dt>
			<dd><?php echo $user->valid?_('Yes'):_('No'); ?></dd>
			<dt><?php echo _('lastLogin'); ?></dt>
			<dd><?php echo $this->Time->toHuman($user->lastLogin); ?></dd>
			<dt><?php echo _('updated'); ?></dt>
			<dd><?php echo $this->Time->toHuman($user->updated); ?></dd>
			<dt><?php echo _('role'); ?></dt>
			<dd>
			
			<select id="role" name="role" class="post-select">
				<?php foreach ($roles as $role): ?>
					<option value="<?php echo $role ?>" <?php echo $user->role==$role? 'selected=""':''; ?>><?php echo $role ?></option>
				<?php endforeach ?>
			</select>
			</dd>
		</dl>
		<?php echo $this->Form->submit('save'); ?>
		
		<?php echo $this->Form->end(); ?>
	</section>
</section>
