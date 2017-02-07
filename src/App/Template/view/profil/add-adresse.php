<?php $this->setTitle('adresse'); ?>
<div class="layout-login">
<section id="Login">
	<header>
		<h1> </h1>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'addAdresse'])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>''],
			'legend'  => ['content'=>'','class'=>''],
			'input'   => [
				'name'  => ['label'=>'name','type'=>'text'],
				'add1'  => ['label'=>'adresse 1','type'=>'text'],
				'add2'  => ['label'=>'adresse 2','type'=>'text'],
				'add3'  => ['label'=>'adresse 3','type'=>'text'],
				'cp'    => ['label'=>'code postale','type'=>'number'],
				'ville' => ['label'=>'ville','type'=>'text'],
			]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>
</div>
