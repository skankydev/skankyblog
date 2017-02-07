<?php if ($result['statu']): ?>

<?php ob_start(); ?>
<li class="img-elem">
	<img class="img-select" src="<?php echo $media['url']; ?>">
	<span class="img-name"><?php echo $media['name']; ?></span>
</li>
<?php $result['html'] = ob_get_clean(); ?>
<?php endif ?>
<?php echo json_encode($result); ?>
