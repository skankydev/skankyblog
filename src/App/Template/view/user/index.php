<?php $this->setTitle('users'); ?>
<section id='Users'>
	<header>
		<h1><?php echo _("Users"); ?></h1>
		<?php echo $this->link('Add User',['action'=>'add']); ?>
	</header>
	<section class="liste-users">
	<table>
		<thead>
			<tr>
				<th><?php echo $this->link('login', ['params'=>$users->sortParams('login')]);?> </th>
				<th><?php echo $this->link('e-mail', ['params'=>$users->sortParams('email')]);?> </th>
				<th><?php echo $this->link('valid', ['params'=>$users->sortParams('valid')]);?> </th>
				<th><?php echo $this->link('last login', ['params'=>$users->sortParams('lastLogin')]);?> </th>
				<th><?php echo $this->link('inscription', ['params'=>$users->sortParams('created')]);?> </th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo $this->link($user->login, ['action'=>'view','params'=>['login'=>$user->login]]);?></td>
				<td><?php echo $user->email; ?></td>
				<td><?php echo $user->valid?'Yes':'No'; ?></td>
				<td><?php echo $this->Time->since($user->lastLogin); ?></td>
				<td><?php echo $this->Time->toHuman($user->created); ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	</section>
	<footer>
		<?php echo $this->element('paginator',$users->getOption()); ?>
	</footer>
</section>