<?php $this->setTitle('Permission'); ?>
<section id="Permission">
	<header>
		<h1>Permission</h1>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'edit','params'=>['name'=>$role->name]])); ?>
	<section>
		<input value="<?php echo $role->_id; ?>" name="_id" id="_id" class="field-input" type="hidden">
		<div class="field text field-completed">
			<label for="name" class="field-label">name</label>
			<input type="text" class="field-input" name="name" value="<?php echo $role->name ?>">
		</div>
		<ul class="controller-list">
		<?php foreach ($role->action as $controller => $action): ?>
				<li class="controller-element">
				<div class="controller"><?php echo $controller ?></div>
				<ul class="action-list">
				<?php foreach ($action as $key => $value): ?>
					<li class="action-element" >
					<span class="action"><?php echo $key; ?></span>
					<div class="empty-space"></div>
					<label class="action-allow success">
						<input type="radio" name="<?php echo 'action['.$controller.']['.$key.']'; ?>" value="allow" <?php echo $value=='allow'?'checked':'' ?>> allow
					</label>
					<label class="action-deny error"> 
						<input type="radio" name="<?php echo 'action['.$controller.']['.$key.']'; ?>" value="deny" <?php echo $value=='deny'?'checked':'' ?>> deny 
					</label>
					</li>
				<?php endforeach ?>
				</ul>
				</li>
		<?php endforeach ?>
		</ul>
	</section>
	<footer>
		<?php echo $this->Form->submit('Save'); ?>
	</footer>
	<?php echo $this->Form->end(); ?>	

</section>

