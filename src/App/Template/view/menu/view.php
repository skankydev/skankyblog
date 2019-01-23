<nav id="Menu">
	<ul>
<?php if (!empty($menu)): ?>		
<?php foreach ($menu->data as $key => $value): ?>
	<?php if (!empty($value->url)): ?>
		<li><a href="<?= $value->url; ?>"><?= $value->text; ?></a></li>
	<?php else: ?>
		<li><?= $this->link($value->text, $value->link);?></li>
	<?php endif ?>
<?php endforeach ?>
<?php endif ?>
	</ul>
</nav>