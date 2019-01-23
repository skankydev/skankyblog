<section>
	<header>
		<h1><?php echo _('commande numero: ').$commande->num; ?></h1>
	</header>
	<section>
		<div>
			<?php echo $commande->clientName; ?><br>
			<?php echo $commande->clientMail; ?><br>
			<?php echo $commande->clientTel; ?><br>
			<?php echo $commande->adresse->add1; ?><br>
			<?php echo $commande->adresse->add2; ?><br>
			<?php echo $commande->adresse->add3; ?><br>
			<?php echo $commande->adresse->cp.' '.$commande->adresse->ville; ?><br>
		</div>
		<table>
			<thead>
				<tr>
					<th><?php echo _('ref') ?></th>
					<th><?php echo _('nom') ?></th>
					<th><?php echo _('quantité') ?></th>
					<th><?php echo _('prix') ?></th>
					<th><?php echo _('total') ?></th>
				</tr>
			</thead>
			<tbody class="">				
			<?php foreach ($commande->product as $key => $product): ?>
				<tr>
					<td><?php echo $product['ref'] ?></td>
					<td><?php echo $product['name'] ?></td>
					<td><?php echo $product['quantity'] ?></td>
					<td><?php echo number_format($product['prix'],2) ?>€</td>
					<td><?php echo number_format($product['total'],2) ?>€</td>
				</tr>
			<?php endforeach ?>	
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3" rowspan="2"></td>
					<td>quantité total</td>
					<td><?php echo $commande->quantityTotal; ?></td>
				</tr>
				<tr>
					<td>prix total</td>
					<td class='total-prix'><?php echo number_format($commande->prixTotal,2); ?>€</td>
				</tr>
			</tfoot>
		</table>
	</section>
	<footer>
		<?php if (!$commande->payment): ?>
			<h3>procéder au paiement</h3>
			<?php echo $this->link('paypal', ['controller'=>'payment','action'=>'paypal','params'=>['commande_id'=>$commande->_id]],['class'=>'']);?>
		<?php endif ?>
	</footer>
</section>