<?php $this->setTitle('Post'); ?>
<section id='Posts'>
	<header>
		<h1><?= _("Post"); ?></h1>
		<?= $this->link('Add Post',['action'=>'add'],['class'=>'btn-default']); ?>
	</header>
	<section class="liste-users">
	<table>
		<thead>
			<tr>
				<th><?= $this->link('titre', ['get'=>$posts->sortParams('name')]);?> </th>
				<th><?= $this->link('slug', ['get'=>$posts->sortParams('slug')]);?> </th>
				<th><?= $this->link('online', ['get'=>$posts->sortParams('online')]);?> </th>
				<th><?= $this->link('updated', ['get'=>$posts->sortParams('updated')]);?> </th>
				<th><?= $this->link('created', ['get'=>$posts->sortParams('created')]);?> </th>
				<th>actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($posts as $post): ?>
			<tr>
				<td><?= $this->link($post->name, ['action'=>'view','params'=>['slug'=>$post->slug]]);?></td>
				<td><?= $post->slug; ?></td>
				<td><?= $post->online?'Yes':'No'; ?></td>
				<td><?= $this->Time->toHuman($post->updated); ?></td>
				<td><?= $this->Time->toHuman($post->created); ?></td>
				<th>
				<?= $this->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['action'=>'edit','params'=>['slug'=>$post->slug]],['class'=>'btn-warning']);?>
				<?= $this->link('<i class="fa fa-trash " aria-hidden="true"></i>', ['action'=>'delete','params'=>['_id'=>$post->_id]],['class'=>'btn-error']);?>
					
				</th>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	</section>
	<footer>
		<?= $this->element('paginator',$posts->getOption()); ?>
	</footer>
</section>
