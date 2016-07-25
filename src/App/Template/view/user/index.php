<section id='Users'>
	<header>
		<h1>Users</h1>
		<?php echo $this->link('Add User',['action'=>'add']); ?>
	</header>
	<section class="liste-users">
		<?php foreach ($users as $user): ?>
			<section class="users-content">
				<header class="auteur">
					<i class="fa fa-user success"></i>
					<?php echo $user->username; ?>
					
				</header>
				<article><?php echo $user->email; ?></article>
			</section>
		<?php endforeach ?>
	</section>

</section>