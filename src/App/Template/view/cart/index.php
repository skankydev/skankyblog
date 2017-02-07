<?php
$this->setTitle('votre panier'); 
$tQ = 0;
$tP = 0;
?>
<section>
	<header>
		<h1>votre panier</h1>
	</header>
	<section class="">
		<table>
			<thead>
				<tr>
					<th><?php echo _('ref') ?></th>
					<th><?php echo _('nom') ?></th>
					<th><?php echo _('quantité') ?></th>
					<th><?php echo _('prix') ?></th>
					<th><?php echo _('total') ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody class="">
			<?php if ($cart): ?>
				
			<?php foreach ($cart as $key => $product): ?>
				<?php 
					$tQ += $product['quantity'];
					$tP += $product['total'];
					$k = $key+1
				 ?>
				<tr>
					<td><?php echo $product['ref'] ?></td>
					<td><?php echo $product['name'] ?></td>
					<td>
						<input class='<?php echo 'product-'.$k; ?>' type="number" value="<?php echo $product['quantity'] ?>">
						<a class='btn-success edit-quantity' data-link="<?php echo $this->request->url(['controller'=>'cart','action'=>'edit','params'=>['key'=>$k]]); ?>" data-key=<?php echo $k ?>>
							<i class="fa fa-pencil" aria-hidden="true"></i>
						</a>
					</td>
					<td><?php echo number_format($product['prix'],2) ?>€</td>
					<td><?php echo number_format($product['total'],2) ?>€</td>
					<td>
						<a class='btn-cart-remove' href="<?php echo $this->request->url(['controller'=>'cart','action'=>'delete','params'=>['key'=>$k,'redirect'=>'redirect']]); ?>">
							<i class="fa fa-trash " aria-hidden="true"></i>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
			<?php else: ?>
				<tr>
					<td colspan=6><?php echo _('votre panier est vide'); ?></td>
				</tr>
			<?php endif ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3" rowspan="2"></td>
					<td>quantité total</td>
					<td><?php echo $tQ; ?></td>
					<td rowspan="2"></td>
				</tr>
				<tr>
					<td>prix total</td>
					<td><?php echo number_format($tP,2); ?>€</td>
				</tr>
			</tfoot>
		</table>
		<?php echo $this->link('passer commande', ['controller'=>'commande','action'=>'create'],['class'=>'btn-success']);?>
	</section>
	<footer>
		
	</footer>
</section>
 <?php $this->startScript(); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('.edit-quantity').on('click',function(e){
		var link = $(this).attr('data-link');
		var key = $(this).attr('data-key');
		var quantity = $('.product-'+key).val();
		link = link+'/'+quantity;
		$.get(link,function(data){
			location.reload();
		});
	});
});
</script>
<?php $this->stopScript(); ?>