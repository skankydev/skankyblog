<?php $this->setTitle('users'); ?>
<section id='Posts'>
	<header>
		<h1><?php echo _("Users"); ?></h1>
	</header>
	<section class="liste-users">
	<table>
		<thead>
			<tr>
				<th><?php echo $this->link('titre', ['params'=>$posts->sortParams('name')]);?> </th>
				<th><?php echo $this->link('slug', ['params'=>$posts->sortParams('slug')]);?> </th>
				<th><?php echo $this->link('online', ['params'=>$posts->sortParams('online')]);?> </th>
				<th><?php echo $this->link('updated', ['params'=>$posts->sortParams('updated')]);?> </th>
				<th><?php echo $this->link('created', ['params'=>$posts->sortParams('created')]);?> </th>
				<th>actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($posts as $post): ?>
			<tr>
				<td><?php echo $this->link($post->name, ['action'=>'view','params'=>['slug'=>$post->slug]]);?></td>
				<td><?php echo $post->slug; ?></td>
				<td><?php echo $post->online?'Yes':'No'; ?></td>
				<td><?php echo $this->Time->toHuman($post->updated); ?></td>
				<td><?php echo $this->Time->toHuman($post->created); ?></td>
				<th><?php echo $this->link('<i class="fa fa-trash" aria-hidden="true"></i>', ['action'=>'delete','params'=>['_id'=>$post->_id]],['class'=>'btn-trash']);?></th>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	</section>
	<footer>
		<?php echo $this->element('paginator',$posts->getOption()); ?>
	</footer>
</section>