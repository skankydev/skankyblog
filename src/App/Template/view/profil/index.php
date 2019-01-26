<?php $this->setTitle($user->login); ?>
<section id="User">
	<header>
		<h1><?= $user->login; ?></h1>
		<?= $this->link('modifier', ['controller'=>'profil','action'=>'edit'],['class'=>'btn-info']);?>
	</header>
	<hr>
	<section>
		<dl>
			<dt><?= _('e-mail'); ?></dt>
			<dd><?= $user->email; ?></dd>
			<dt><?= _('login'); ?></dt>
			<dd><?= $user->login; ?></dd>
			<dt><?= _('password'); ?></dt>
			<dd><?= $this->link('change le mot de passe', ['controller'=>'user','action'=>'changePass']);?></dd>
			<dt><?= _('nom'); ?></dt>
			<dd><?= $profil->civilite.' '.$profil->nom.' '.$profil->prenom.' '; ?></dd>
			<dt><?= _('téléphone'); ?></dt>
			<dd><?= $profil->telephone; ?></dd>
			<?php if (!empty($profil->mobil)): ?>
				<dt><?= _('téléphone 2'); ?></dt>
				<dd><?= $profil->mobil; ?></dd>
			<?php endif ?>
		</dl>
	</section>
	<section>
		<h2><?= _('adresse') ?></h2>
		<div class="adresse-list">
		<?php foreach ($profil->adresse as $key => $adresse): ?>
			<div class='adresse'>
				<div class="adresse-name"><?= $adresse->name; ?></div>
				<div>
					<?= $adresse->add1 ?><br>
					<?= $adresse->add2 ?><br>
					<?= $adresse->add3 ?><br>
				</div>
				<div><?= $adresse->cp.' '.$adresse->ville ?></div>
				<span>
					<?= $this->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
					['controller'=>'profil','action'=>'editAdresse','params'=>['key'=>$key]],['class'=>'btn-warning']);?>
				</span>
				<span>
					<?= $this->link('<i class="fa fa-trash " aria-hidden="true"></i>',
					['controller'=>'profil','action'=>'deleteAdresse','params'=>['key'=>$key]],['class'=>'btn-error']);?>
				</span>
			</div>
		<?php endforeach ?>
		</div>
		<div>
			<?= $this->link('Ajouter une adresse', ['controller'=>'profil','action'=>'addAdresse'],['class'=>'btn-info']);?>
		</div>
	</section>
	<footer>
		
	</footer>
</section>