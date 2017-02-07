<?php $this->setTitle('Product'); ?>
<section>
	<header>
		<h1><?php echo $product->name ?></h1>
	</header>
	<section class="product-view">
		<div class="product-image">
			<div class="product-image-list">
				<div class="arrow-up">
					<i class="fa fa-caret-up" aria-hidden="true"></i>
				</div>
				<ul class="product-the-list">
				<?php foreach ($product->media as $media): ?>
					<li><img class="product-image-list-img" src="<?php echo $media->url ?>" alt="<?php echo $product->name ?>"></li>
				<?php endforeach ?>
				</ul>
				<div class="arrow-down">
					<i class="fa fa-caret-down" aria-hidden="true"></i>
				</div>
			</div>
			<div class="product-image-master">
				<img class="product-image-master-img" src="<?php echo $product->media[0]->url ?>">
			</div>
		</div>
		<div class="product-attr">
			<dl>
				<dt><?php echo _('referance'); ?></dt>
				<dd><span class="ref"><?php echo $product->ref; ?></span></dd>
				<dt><?php echo _('prix'); ?></dt>
				<dd><?php echo number_format($product->prix,2); ?>€</dd>
				<dt><?php echo _('quantité'); ?></dt>
				<dd><input type="number" id="quantite-<?php echo $product->ref; ?>" value="1"></dd>
				<dt><?php echo _('ajouter au panier'); ?></dt>
				<dd><button class="btn-success add-cart" data-link="<?php echo $this->request->url(['controller'=>'cart','action'=>'add','params'=>['ref'=>$product->ref]]); ?>" data-ref="<?php echo $product->ref; ?>">ajouter</button></dd>
			</dl>
		</div>
	</section>
	<section class="product-description">
		<?php echo $product->description ?>
	</section>
	<footer>
		
	</footer>
	<div id="Cart"></div>
</section>
 <?php $this->startScript(); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('.product-image-list-img').on('click',function(e){
		var src = $(this).attr('src');
		$('.product-image-master-img').attr('src',src);
	});
	var pas = 0;
	var size = $('.product-the-list').height();
	var dSize = $('.product-image-list').height();
	var dif = dSize - size;
/*	console.log(step);
	console.log(size);
	console.log(dSize);
	console.log(dif);*/
	$('.arrow-up').on('click',function(e){
		var step = $('.product-image-list-img:first').height();
		var pos = $('.product-the-list').position();
		var top  = pos.top-step;
		$('.product-the-list').css('top',top+'px');
		//console.log(pos);
		//var pos = parseInt(this.list.style.left)?parseInt(this.list.style.left):0;
	});
	$('.arrow-down').on('click',function(e){
		var step = $('.product-image-list-img:first').height();
		var pos = $('.product-the-list').position();
		var top = pos.top+step;
		$('.product-the-list').css('top',top+'px');

	});
});
</script>
<?php $this->stopScript(); ?>