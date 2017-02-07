<?php 
$cart=SkankyDev\Utilities\Session::get('cart');
$count = 0;
if($cart){
	$count = count($cart);
}
?>
<div class="cart-element hideaway">
	<header class="cart-btn-containe">
		<a class="hideaway-btn">
			<i class="fa fa-shopping-cart" aria-hidden="true"></i>
			<span class="cart-count"><?php echo $count ?></span>
		</a>
	</header>
	<section class="cart-content cart-table">
		<table>
			<thead>
				<tr>
					<th><?php echo _('ref') ?></th>
					<th><?php echo _('nom') ?></th>
					<th><?php echo _('quantité') ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody class="cart-list">
			<?php if ($count): ?>
			<?php foreach ($cart as $key => $product): ?>
				<tr>
					<td><?php echo $product['ref'] ?></td>
					<td><?php echo $product['name'] ?></td>
					<td><?php echo $product['quantity'] ?></td>
					<td><a class='btn-cart-remove' data-link="<?php echo $this->request->url(['controller'=>'cart','action'=>'delete','params'=>['key'=>$key]]); ?>;
	"><i class="fa fa-trash " aria-hidden="true"></i></a></td>
				</tr>
			<?php endforeach ?>
			<?php else: ?>
				<tr>
					<td colspan=4><?php echo _('votre panier est vide'); ?></td>
				</tr>
			<?php endif ?>
			</tbody>
		</table>
		<?php echo $this->link('Voir mon panier', ['controller'=>'cart','action'=>'index',],['class'=>'btn-success']);?>
	</section>
</div>
 <?php $this->startScript(); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('.cart-table').on('click','.btn-cart-remove',function(e){
		var link = $(this).attr('data-link');
		$.get(link,function(data){
			$('.cart-count').html(data.count);
			$('.cart-list').html(data.html);
		},"json");
	});

	$('.add-cart').on('click',function(e){
		var ref = $(this).attr('data-ref');
		var q = $('#quantite-'+ref).val();
		var link = $(this).attr('data-link');
		link = link+'/'+q;
		$.get(link,function(data){
			$('.cart-count').html(data.count);
			$('.cart-list').html(data.html);
		},"json");
	});

});
</script>
<?php $this->stopScript(); ?>