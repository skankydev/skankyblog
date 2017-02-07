<?php $this->setTitle('Produit'); ?>
<section>
	<header>
		<h1></h1>
	</header>
	<section class='product-list'>
		<?php foreach ($products as $product): ?>
			<div class="product">
			<?php ob_start(); ?>
				<img class="product-img" src="<?php echo isset($product->media[0])?$product->media[0]['url']:'default'; ?>" alt="<?php echo $product->name; ?>">
				<div class="product-text">
					<span class="product-name"><?php echo $product->name; ?></span>
					<span class="product-prix"><?php echo number_format($product->prix,2); ?>€</span>
				</div>
			
			<?php 
			$text = ob_get_clean(); 
			echo $this->link($text, ['action'=>'view','params'=>['ref'=>$product->ref]]);?>
			</div>
		<?php endforeach ?>
	</section>
	<footer>
		<?php echo $this->element('paginator',$products->getOption()); ?>
	</footer>
</section>
