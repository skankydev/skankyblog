<?php $this->setTitle('Profil'); ?>
<div class="layout-login">
<section id="Login">
	<header>
		<h1>Votre Profil</h1>
	</header>
	<?= $this->Form->start($profil); ?>
	<section>
		<?= $this->Form->fieldset([
			'fieldset'=> ['class'=>''],
			'legend'  => ['content'=>'','class'=>''],
			'input'   => [
				'_id'        => ['type' =>'hidden'],
				'user_email' => ['type'=>'hidden'],
				'civilite'   => ['label'=>'civilite','type'=>'radio','option'=>['Mr'=>'Mr','Mme'=>'Mme']],
				'nom'        => ['label'=>'nom','type'=>'text'],
				'prenom'     => ['label'=>'prenom','type'=>'text'],
				'telephone'  => ['label'=>'téléphone','type'=>'tel'],
				'mobil'      => ['label'=>'téléphone 2','type'=>'tel'],
			]
		]); ?>
	</section>
	<footer>
		<?= $this->Form->submit('Envoyer'); ?>
	</footer>
	<?= $this->Form->end(); ?>
</section>
</div>