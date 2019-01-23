<?php 
$this->setTitle('Commande'); 
$tQ = 0;
$tP = 0;
?>
<section>
	<header>
		<h1><?php echo _('Commande'); ?></h1>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'create'])); ?>
	<section>
		<dl>
			<dt><?php echo _('e-mail'); ?></dt>
			<dd><?php echo $user->email; ?></dd>
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
		<h2><?php echo _('adresse de livraison') ?></h2>
		<div class="adresse-list">
		<?php foreach ($profil->adresse as $key => $adresse): ?>
			<div class='adresse'>
				<div>
				<input id="adresse.<?php echo $key ?>" name="adresse" value="<?php echo $key ?>" type="radio" <?php echo $key==0?'checked="checked"':''; ?>>
				<label for="adresse.<?php echo $key ?>"><?php echo $adresse->name; ?></label>
				</div>
				<div>
					<?php echo $adresse->add1; ?><br>
					<?php echo $adresse->add2; ?><br>
					<?php echo $adresse->add3; ?><br>
				</div>
				<div><?php echo $adresse->cp.' '.$adresse->ville ?></div>
			</div>
		<?php endforeach ?>
		</div>
		<div>
			<?php echo $this->link('Ajouter une adresse', ['controller'=>'profil','action'=>'addAdresse'],['class'=>'btn-info']);?>
		</div>
	</section>
	<section>
		<table>
			<thead>
				<tr>
					<th><?php echo _('ref') ?></th>
					<th><?php echo _('nom') ?></th>
					<th><?php echo _('quantité') ?></th>
					<th><?php echo _('prix') ?></th>
					<th><?php echo _('total') ?></th>
				</tr>
			</thead>
			<tbody class="">
			<?php if ($cart): ?>
				
			<?php foreach ($cart as $key => $product): ?>
				<?php 
					$tQ += $product['quantity'];
					$tP += $product['total'];
				 ?>
				<tr>
					<td><?php echo $product['ref'] ?></td>
					<td><?php echo $product['name'] ?></td>
					<td><?php echo $product['quantity'] ?></td>
					<td><?php echo number_format($product['prix'],2) ?>€</td>
					<td><?php echo number_format($product['total'],2) ?>€</td>
				</tr>
			<?php endforeach ?>
				<tr>
					<?php $dprix =  0;?>
					<td><?php echo 'Frais de port'; ?></td>
					<td>
					<?php foreach ($transport as $key => $port): ?>
						<?php 
						$curentPrix =  (float)$port->prix;
						if($port->gratuit){
							$curentPrix = ($tP<(float)$port->gratuit)?$curentPrix:0;
						} 
						?>
						<input 
							id="fraisPort.<?php echo $port->ref ?>" 
							name="fraisPort" 
							value="<?php echo $port->ref ?>" 
							type="radio" 
							<?php if($port->ref == 'default'){
								echo 'checked="checked" ';
								$dprix = $curentPrix;
							} ?>
							
							data-prix="<?php echo number_format($curentPrix,2); ?>">
						<label for="fraisPort.<?php echo $port->ref ?>">
							<?php echo $port->libelle; ?>
						</label>
						<br>
					<?php endforeach ?>
					</td>
					<td></td>
					<td></td>
					<td class='fdp-prix'><?php echo number_format($dprix,2); ?>€</td>
				</tr>
				<?php 
				$tPini = $tP;
				$tP += $dprix; 
				?>
			<?php else: ?>
				<tr>
					<td colspan=5><?php echo _('votre panier est vide'); ?></td>
				</tr>
			<?php endif ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3" rowspan="2"></td>
					<td>quantité total</td>
					<td><?php echo $tQ; ?></td>
				</tr>
				<tr>
					<td>prix total</td>
					<td class='total-prix'><?php echo number_format($tP,2); ?>€</td>
				</tr>
			</tfoot>
		</table>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>
 <?php $this->startScript(); ?>
<script type="text/javascript">
$(document).ready(function(){
	var $prixtotal = <?php echo $tPini ?>;
	$('input[name="fraisPort"]').on('change',function(e){
		var prix = $(this).attr('data-prix');
		$('.fdp-prix').html(prix+'€');
		$p = $prixtotal+parseFloat(prix); 
		$('.total-prix').html($p.toFixed(2)+'€');
	});
});
</script>
<?php $this->stopScript(); ?>