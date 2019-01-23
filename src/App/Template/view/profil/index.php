<?php $this->setTitle($user->login); ?>
<section id="User">
	<header>
		<h1><?php echo $user->login; ?></h1>
		<?php echo $this->link('modifier', ['controller'=>'profil','action'=>'edit'],['class'=>'btn-info']);?>
		<?php echo $this->link('mes commande', ['controller'=>'commande','action'=>'index'],['class'=>'btn-info']);?>
	</header>
	<hr>
	<section>
		<dl>
			<dt><?php echo _('e-mail'); ?></dt>
			<dd><?php echo $user->email; ?></dd>
			<dt><?php echo _('login'); ?></dt>
			<dd><?php echo $user->login; ?></dd>
			<dt><?php echo _('password'); ?></dt>
			<dd><?php echo $this->link('change le mot de passe', ['controller'=>'user','action'=>'changePass']);?></dd>
			<dt><?php echo _('nom'); ?></dt>
			<dd><?php echo $profil->civilite.' '.$profil->nom.' '.$profil->prenom.' '; ?></dd>
			<dt><?php echo _('téléphone'); ?></dt>
			<dd><?php echo $profil->telephone; ?></dd>
			<?php if (!empty($profil->mobil)): ?>
				<dt><?php echo _('téléphone 2'); ?></dt>
				<dd><?php echo $profil->mobil; ?></dd>
			<?php endif ?>
		</dl>
	</section>
	<section>
		<h2><?php echo _('adresse') ?></h2>
		<div class="adresse-list">
		<?php foreach ($profil->adresse as $key => $adresse): ?>
			<div class='adresse'>
				<div class="adresse-name"><?php echo $adresse->name; ?></div>
				<div>
					<?php echo $adresse->add1 ?><br>
					<?php echo $adresse->add2 ?><br>
					<?php echo $adresse->add3 ?><br>
				</div>
				<div><?php echo $adresse->cp.' '.$adresse->ville ?></div>
				<span>
					<?php echo $this->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
					['controller'=>'profil','action'=>'editAdresse','params'=>['key'=>$key]],['class'=>'btn-warning']);?>
				</span>
				<span>
					<?php echo $this->link('<i class="fa fa-trash " aria-hidden="true"></i>',
					['controller'=>'profil','action'=>'deleteAdresse','params'=>['key'=>$key]],['class'=>'btn-error']);?>
				</span>
			</div>
		<?php endforeach ?>
		</div>
		<div>
			<?php echo $this->link('Ajouter une adresse', ['controller'=>'profil','action'=>'addAdresse'],['class'=>'btn-info']);?>
		</div>
	</section>
	<footer>
		
	</footer>
</section>