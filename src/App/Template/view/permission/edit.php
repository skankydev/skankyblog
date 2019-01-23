<?php $this->setTitle('Permission'); ?>
<section id="Permission">
	<header>
		<h1>Permission</h1>
	</header>
	<?= $this->Form->start($this->request->url(['action'=>'edit','params'=>['name'=>$role->name]])); ?>
	<section>
		<input value="<?= $role->_id; ?>" name="_id" id="_id" class="field-input" type="hidden">
		<div class="field text field-completed">
			<label for="name" class="field-label">name</label>
			<input type="text" class="field-input" name="name" value="<?= $role->name ?>">
		</div>
		<ul class="controller-list">
		<?php foreach ($role->action as $controller => $action): ?>
				<li class="controller-element">
				<div class="controller"><?= $controller ?></div>
				<ul class="action-list">
				<?php foreach ($action as $key => $value): ?>
					<li class="action-element" >
					<span class="action"><?= $key; ?></span>
					<div class="empty-space"></div>
					<div>
						<input type="radio" id="<?= 'action-'.$controller.'-'.$key.'-allow'; ?>" name="<?= 'action['.$controller.']['.$key.']'; ?>" value="allow" <?= $value=='allow'?'checked':'' ?>>
						<label class="action-allow success" for="<?= 'action-'.$controller.'-'.$key.'-allow'; ?>">allow</label>
					</div>
					<div>
						<input type="radio" id="<?= 'action-'.$controller.'-'.$key.'-deny'; ?>" name="<?= 'action['.$controller.']['.$key.']'; ?>" value="deny" <?= $value=='deny'?'checked':'' ?>>
						<label class="action-deny error" for="<?= 'action-'.$controller.'-'.$key.'-deny'; ?>">deny</label>
					</div>
					</li>
				<?php endforeach ?>
				</ul>
				</li>
		<?php endforeach ?>
		</ul>
	</section>
	<footer>
		<?= $this->Form->submit('Save'); ?>
	</footer>
	<?= $this->Form->end(); ?>	

</section>

