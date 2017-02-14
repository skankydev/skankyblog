<?php $this->setTitle('users'); ?>
<section id='Users'>
	<header>
		<h1><?php echo _("Users"); ?></h1>
	</header>
	<section class="liste-users">
	<table>
		<thead>
			<tr>
				<th><?php echo $this->link('login', ['params'=>$users->sortParams('login')]);?> </th>
				<th><?php echo $this->link('e-mail', ['params'=>$users->sortParams('email')]);?> </th>
				<th><?php echo $this->link('role', ['params'=>$users->sortParams('role')]);?> </th>
				<th><?php echo $this->link('valid', ['params'=>$users->sortParams('valid')]);?> </th>
				<th><?php echo $this->link('last login', ['params'=>$users->sortParams('lastLogin')]);?> </th>
				<th><?php echo $this->link('inscription', ['params'=>$users->sortParams('created')]);?> </th>
				<th>actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo $this->link($user->login, ['action'=>'view','params'=>['login'=>$user->login]]);?></td>
				<td><?php echo $user->email; ?></td>
				<td><?php echo $user->role; ?></td>
				<td><?php echo $user->valid?'Yes':'No'; ?></td>
				<td><?php echo $user->lastLogin?$this->Time->since($user->lastLogin):'No'; ?></td>
				<td><?php echo $this->Time->toHuman($user->created); ?></td>
				<th><?php echo $this->link('<i class="fa fa-trash" aria-hidden="true"></i>', ['action'=>'delete','params'=>['_id'=>$user->_id]],['class'=>'btn-trash']);?></th>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	</section>
	<footer>
		<?php echo $this->element('paginator',$users->getOption()); ?>
	</footer>
</section>