<?php 
$result['count'] = count($cart);
ob_start(); ?> 
<?php if ($result['count']): ?>
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

<?php
$result['html'] = ob_get_clean();
echo json_encode($result); 
?>