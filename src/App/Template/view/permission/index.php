<?php $this->setTitle('Permission'); ?>
<section>
	<header>
		<h1>Roles</h1>
	</header>
	<section>
		<ul>
			<?php foreach ($roles as $role): ?>
				<?php if ($role->name != 'init'): ?>
					<li><?php echo $this->link($role->name , ['action'=>'edit','params'=>['name'=>$role->name]]);?></li>
				<?php endif ?>
			<?php endforeach ?>
		</ul>
	</section>
	<footer>
		<?php echo $this->link('Ajouter un role',['action'=>'add'],['class'=>'btn-default']); ?>
		<?php echo $this->link('init',['action'=>'init'],['class'=>'btn-default']); ?>
		<?php echo $this->link('update',['action'=>'update'],['class'=>'btn-default']); ?>
	</footer>
</section>