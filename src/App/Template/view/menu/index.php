<?php $this->setTitle(_('Menu')); ?>
<section>
	<header>
		<h1><?php echo _('Menu'); ?> </h1>
	</header>
	<section>
		<ul>
		<?php foreach ($menus as $menu): ?>
			<li><?php echo $this->link($menu->name , ['action'=>'edit','params'=>['name'=>$menu->name]]);?></li>
		<?php endforeach ?>
		</ul>		
	</section>
	<footer>
		<?php echo $this->link('new Menu', ['controller'=>'Menu','action'=>'add'],['class'=>'btn-default']);?>
	</footer>
</section>