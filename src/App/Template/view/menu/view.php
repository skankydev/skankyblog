<nav id="Menu">
	<ul>
<?php foreach ($menu->data as $key => $value): ?>
	<?php if (!empty($value->url)): ?>
		<li><a href="<?php echo $value->url; ?>"><?php echo $value->text; ?></a></li>
	<?php else: ?>
		<li><?php echo $this->link($value->text, $value->link);?></li>
	<?php endif ?>
<?php endforeach ?>
	</ul>
</nav>