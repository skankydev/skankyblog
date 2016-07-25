<section>
	<header><h1>Edit message</h1></header>
	<?php echo $this->Form->start($this->request->url(['action'=>'edit','params'=>['_id'=>$message->_id]])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset_message'],
			'legend'  => ['content'=>'creat a new post','class'=>'legend_post'],
			'input'   => [
				'_id' => ['type'=>'hidden'],
				'posts_id' => ['type'=>'hidden'],
				'author'  => ['label'=>'author'],
				'message' => ['label'=>'message','type'=>'textarea'],
			]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>