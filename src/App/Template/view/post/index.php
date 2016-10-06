<?php $this->setTitle('articles'); ?>
<section id='Posts'>
	<?php foreach ($posts as $post): ?>
	<section class='post-liste'>
		<header><h2><?php echo $this->link($post->name,['action'=>'view','params'=>['sulg'=>$post->slug]],['class'=>'post-title']) ; ?></h2></header>
		<div class="post-content">
			<p><?php echo $post->content; ?></p>
		</div>
		<footer>
			<?php if (isset($post->tags)): ?>
				<div>
				<?php foreach ($post->tags as $tag): ?>
					<span class="legend"><?php echo $tag; ?></span>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<nav class="menu-action">
				<ul>
					<li><?php echo $this->link('Edit Post',['action'=>'edit', 'params'=>['sulg'=>$post->slug]],['class'=>'btn-warning']); ?></li>
					<li><?php echo $this->link('Delete Post',['action'=>'delete', 'params'=>['sulg'=>$post->slug]],['class'=>'btn-error']); ?></li>
				</ul>
			</nav>
		</footer>
	</section>
	<?php endforeach; ?>
	<footer>
		<?php echo $this->element('paginator',$posts->getOption()); ?>
	</footer>
	<?php echo $this->link('Add Post',['action'=>'add'],['class'=>'btn-default']); ?>
</section>
