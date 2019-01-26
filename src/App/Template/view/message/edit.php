<section>
	<header><h1>Edit message</h1></header>
	<?= $this->Form->start($this->request->url(['action'=>'edit','params'=>['_id'=>$message->_id]])); ?>
	<section>
		<?= $this->Form->fieldset([
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
		<?= $this->Form->submit('Envoyer'); ?>
	</footer>
	<?= $this->Form->end(); ?>
</section>