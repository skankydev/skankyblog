<section id='Message-Form'>
	<header><h2>Add message</h2></header>
	<?php echo $this->Flash->display(); ?>
	<?php echo $this->Form->start($this->request->url(['controller'=>'message','action'=>'add','params'=>['post_id'=>$post_id]])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-message'],
			'legend'  => ['content'=>'creat a new message','class'=>'legend_post'],
			'input'   => [
				'post_id' => ['type'=>'hidden','value'=>$post_id],
				'message' => ['label'=>'message','type'=>'textarea'],
			]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>
