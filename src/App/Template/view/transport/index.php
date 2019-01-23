<?php $this->setTitle(_('Frais de port')); ?>
<section>
	<header>
		<h1><?php echo _('Frais de port'); ?></h1>
	</header>
	<section>
		<table>
		<thead>
			<tr>
				<th><?php echo $this->link('ref', ['params'=>$transport->sortParams('ref')]);?> </th>
				<th><?php echo $this->link('libelle', ['params'=>$transport->sortParams('libelle')]);?> </th>
				<th><?php echo $this->link('prix', ['params'=>$transport->sortParams('prix')]);?> </th>
				<th><?php echo $this->link('gratuit a partire', ['params'=>$transport->sortParams('gratuit')]);?> </th>
				<th><?php echo $this->link('created', ['params'=>$transport->sortParams('created')]);?> </th>
				<th>actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($transport as $port): ?>
			<tr>
				<td><?php echo $port->ref; ?></td>
				<td><?php echo $port->libelle; ?></td>
				<td><?php echo $port->prix; ?></td>
				<td><?php echo $port->gratuit; ?></td>
				<td><?php echo $this->Time->toHuman($port->created); ?></td>
				<th>
				<?php echo $this->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['action'=>'edit','params'=>['ref'=>$port->ref]],['class'=>'btn-trash']);?>
				<?php echo $this->link('<i class="fa fa-trash" aria-hidden="true"></i>', ['action'=>'delete','params'=>['ref'=>$port->_id]],['class'=>'btn-trash']);?>	
				</th>
			</tr>
		<?php endforeach ?>
		</tbody>
		</table>
	</section>
	<footer>
		<?php echo $this->element('paginator',$transport->getOption()); ?>
	</footer>
	<?php echo $this->link('Add Transport',['action'=>'add'],['class'=>'btn-default']); ?>
</section>
