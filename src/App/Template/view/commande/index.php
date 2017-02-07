<?php $this->setTitle('Commade'); ?>
<section>
	<header>
		<h1><?php echo _('Commande'); ?></h1>
	</header>
	<section>
	<table>
		<thead>
			<tr>
				<th><?php echo $this->link('num', ['params'=>$commandes->sortParams('num')]);?></th>
				<th><?php echo $this->link('quantité', ['params'=>$commandes->sortParams('quantityTotal')]);?></th>
				<th><?php echo $this->link('prix', ['params'=>$commandes->sortParams('prixTotal')]);?></th>
				<th><?php echo _('payé');?></th>
				<th><?php echo $this->link('date', ['params'=>$commandes->sortParams('created')]);?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($commandes as $commande): ?>
				<tr>
					<td><?php echo $this->link($commande->num, ['action'=>'view','params'=>['num'=>$commande->num]]);?></td>
					<td><?php echo $commande->quantityTotal; ?></td>
					<td><?php echo $commande->prixTotal; ?></td>
					<td><?php echo $commande->paiment?'oui':'non'; ?></td>
					<td><?php echo $this->Time->toHuman($commande->created); ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	</section>
	<footer>
		<?php echo $this->element('paginator',$commandes->getOption()); ?>
	</footer>
</section>
