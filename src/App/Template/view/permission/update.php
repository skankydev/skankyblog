<?php $this->setTitle('permission update'); ?>
<section>
	<header>
		<h1>Permission update</h1>
	</header>
	<section>
	<ul class="controller-list">
		<?php foreach ($init->action as $controller => $action): ?>
		<li class="controller-element">
			<div class="controller"><?php echo $controller ?></div>
			<ul class="action-list">
			<?php foreach ($action as $key => $value): ?>
				<li class="action-element" >
					<span class="action"><?php echo $key; ?></span>
					<div class="empty-space"></div>
				</li>
			<?php endforeach ?>
			</ul>
		</li>
		<?php endforeach ?>
	</ul>	
	</section>
	<footer>
		
	</footer>
</section>