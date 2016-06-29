<section id='Task-form'>
	<header><h2>Add task</h2></header>
	<?php echo $this->Form->start($this->request->url(['controller'=>'JeTest','action'=>'index'])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'legend'  => ['content'=>'new task'],
			'input'   => [
				'tache' => ['label'=>'tache'],
				'message' => ['label'=>'message'],
				'statu' => ['label'=>'statu','type'=>'select','option'=>['a faire','en cour','fini','on vera plus tard']],
				'criticite'=>['label'=>'criticité','type'=>'radio','option'=>['faible','moyen','fort']]
			]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>
<section id="Task-List">
	<header>
	</header>
	<serction>
		<?php foreach ($result as $document): ?>
			<?php debug($document); ?>
		<?php endforeach ?>
	</serction>
	<footer>
	</footer>
</section>