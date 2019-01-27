<?php $this->setTitle('articles'); ?>
<section id='Posts'>
	<?php foreach ($posts as $post): ?>
	<section class='post-liste'>
		<header><h2><?= $this->link($post->name,['action'=>'view','params'=>['sulg'=>$post->slug]],['class'=>'post-title']) ; ?></h2></header>
		<div class="post-content">
			<p><?= $post->content; ?></p>
		</div>
		<footer>
			<?php if (isset($post->tags)): ?>
				<div>
				<?php foreach ($post->tags as $tag): ?>
					<span class="legend"><?= $tag; ?></span>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</footer>
	</section>
	<?php endforeach; ?>
	<footer>
		<?= $this->element('paginator',$posts->getOption()); ?>
	</footer>
</section>
