<?php $this->setTitle('Taxonomie'); ?>
<section>
	<header>
		<h1><?php echo _("Taxonomies"); ?></h1>
	</header>
	<section>

		<table>
		<thead>
			<tr>
				<th><?php echo $this->link('tag', ['get'=>$taxonomies->sortParams('name')]);?> </th>
				<th><?php echo $this->link('count', ['get'=>$taxonomies->sortParams('count')]);?> </th>
				<th><?php echo $this->link('created', ['get'=>$taxonomies->sortParams('created')]);?> </th>
				<th>actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($taxonomies as $tag): ?>
			<tr>
				<td><?php echo $tag->name;?></td>
				<td><?php echo $tag->count;?></td>
				<td><?php echo $this->Time->toHuman($tag->created); ?></td>
				<th><?php echo $this->link('<i class="fa fa-trash" aria-hidden="true"></i>', ['action'=>'delete','params'=>['_id'=>$tag->_id]],['class'=>'btn-trash']);?></th>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	</section>
	<footer>
		<?php echo $this->element('paginator',$taxonomies->getOption()); ?>
	</footer>
	<?php echo $this->link('Add Tag',['action'=>'add'],['class'=>'btn-default']); ?>
</section>
