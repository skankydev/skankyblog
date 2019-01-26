<?php $this->setTitle('users'); ?>
<section id='Users'>
	<header>
		<h1><?= _("Users"); ?></h1>
	</header>
	<section class="liste-users">
	<table>
		<thead>
			<tr>
				<th><?= $this->link('login', ['get'=>$users->sortParams('login')]);?> </th>
				<th><?= $this->link('e-mail', ['get'=>$users->sortParams('email')]);?> </th>
				<th><?= $this->link('role', ['get'=>$users->sortParams('role')]);?> </th>
				<th><?= $this->link('valid', ['get'=>$users->sortParams('valid')]);?> </th>
				<th><?= $this->link('last login', ['get'=>$users->sortParams('lastLogin')]);?> </th>
				<th><?= $this->link('inscription', ['get'=>$users->sortParams('created')]);?> </th>
				<th>actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?= $this->link($user->login, ['action'=>'view','params'=>['login'=>$user->login]]);?></td>
				<td><?= $user->email; ?></td>
				<td><?= $user->role; ?></td>
				<td><?= $user->valid?'Yes':'No'; ?></td>
				<td><?= $user->lastLogin?$this->Time->since($user->lastLogin):'No'; ?></td>
				<td><?= $this->Time->toHuman($user->created); ?></td>
				<th><?= $this->link('<i class="fa fa-trash" aria-hidden="true"></i>', ['action'=>'delete','params'=>['_id'=>$user->_id]],['class'=>'btn-trash']);?></th>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	</section>
	<footer>
		<?= $this->element('paginator',$users->getOption()); ?>
	</footer>
</section>