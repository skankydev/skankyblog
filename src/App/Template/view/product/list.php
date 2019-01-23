<?php $this->setTitle('Product'); ?>
<section id="Product">
	<header>
		<h1><?php echo _("Product"); ?></h1>
		<?php echo $this->link('Add Product',['action'=>'add'],['class'=>'btn-default']); ?>
	</header>
	<section class="liste-users">
	<table>
		<thead>
			<tr>
				<th><?php echo $this->link('ref', ['get'=>$products->sortParams('ref')]);?></th>
				<th><?php echo $this->link('name', ['get'=>$products->sortParams('name')]);?></th>
				<th><?php echo $this->link('prix', ['get'=>$products->sortParams('prix')]);?></th>
				<th><?php echo $this->link('en stock', ['get'=>$products->sortParams('stock')]);?></th>
				<th><?php echo $this->link('online', ['get'=>$products->sortParams('online')]);?></th>
				<th><?php echo $this->link('updated', ['get'=>$products->sortParams('updated')]);?></th>
				<th><?php echo $this->link('created', ['get'=>$products->sortParams('created')]);?></th>
				<th>actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($products as $product): ?>
			<tr>
				<td><?php echo $this->link($product->ref, ['action'=>'view','params'=>['ref'=>$product->ref]]);?></td>
				<td><?php echo $product->name; ?></td>
				<td><?php echo $product->prix; ?> €</td>
				<td><?php echo $product->stock?'Yes':'No'; ?></td>
				<td><?php echo $product->online?'Yes':'No'; ?></td>
				<td><?php echo $this->Time->toHuman($product->updated); ?></td>
				<td><?php echo $this->Time->toHuman($product->created); ?></td>
				<th>
				<?php echo $this->link('<i class="fa fa-picture-o" aria-hidden="true"></i>', ['action'=>'media','params'=>['ref'=>$product->ref]],['class'=>'btn-default']);?>
				<?php echo $this->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['action'=>'edit','params'=>['ref'=>$product->ref]],['class'=>'btn-warning']);?>
				<?php echo $this->link('<i class="fa fa-trash " aria-hidden="true"></i>', ['action'=>'delete','params'=>['_id'=>$product->_id]],['class'=>'btn-error']);?>
				</th>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	</section>
	<footer>
		<?php echo $this->element('paginator',$products->getOption()); ?>
	</footer>
</section>