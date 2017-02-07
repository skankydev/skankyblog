<?php if ($result['statu']): ?>

<?php ob_start(); ?>
<li class="img-elem">
	<img class="img-select" src="<?php echo $media['url']; ?>" data-name="<?php echo $media['name']; ?>" data-size="<?php echo $media['size']; ?>" data-type="<?php echo $media['type']; ?>">
	<span class="img-name"><?php echo $media['name']; ?></span>
</li>
<?php $result['html'] = ob_get_clean(); ?>
<?php endif ?>
<?php echo json_encode($result); ?>

		
