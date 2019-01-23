<?php $this->setTitle('Commande'); ?>
<section id="Product">
	<header>
		<h1><?php echo _("Commande"); ?></h1>
	</header>
	<section>
	<table>
		<thead>
			<tr>
				<th><?php echo $this->link('num', ['params'=>$commandes->sortParams('num')]);?></th>
				<th><?php echo $this->link('name', ['params'=>$commandes->sortParams('clientName')]);?></th>
				<th><?php echo $this->link('prix', ['params'=>$commandes->sortParams('prixTotal')]);?></th>
				<th><?php echo $this->link('quantité', ['params'=>$commandes->sortParams('quantityTotal')]);?></th>
				<th><?php echo $this->link('payment', ['params'=>$commandes->sortParams('payment')]);?></th>
				<th><?php echo $this->link('created', ['params'=>$commandes->sortParams('created')]);?></th>
				<th>actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($commandes as $commande): ?>
			<tr>
				<td><?php echo $commande->num; ?></td>
				<td><?php echo $commande->clientName; ?></td>
				<td><?php echo number_format($commande->prixTotal,2); ?> €</td>
				<td><?php echo $commande->quantityTotal; ?></td>
				<td><?php echo $commande->payment?'Yes':'No'; ?></td>
				<td><?php echo $this->Time->toHuman($commande->created); ?></td>
				<th>
				<?php echo $this->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['action'=>'adminView','params'=>['num'=>$commande->num]],['class'=>'btn-default']);?>
				</th>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	</section>
	<footer>
		<?php echo $this->element('paginator',$commandes->getOption()); ?>
	</footer>
</section>