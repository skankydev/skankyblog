<section>
	<header><h1>Edit Post</h1></header>
	<?php echo $this->Form->start($this->request->url(['action'=>'edit','params'=>['slug'=>$post->slug]])); ?>
	<section>
		<?php echo $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'edite a post','class'=>'legend-post'],
			'input'   => [
					'_id'        => ['type' =>'hidden'],
					'name'       => ['label'=>'name'],
					'slug'       => ['label'=>'slug'],
					'content'    => ['label'=>'content','type'=>'textarea','rows'=>'8','cols'=>'50'],
					'tags'       => ['label'=>'tags','labelAttr'=>['class'=>'tags-label'],'type'=>'select','option'=>['joli','test','machin','youpi','marche'],'multiple'=>'checkbox','attr'=>['class'=>'checkbox']],
					'online'     => ['label'=>'online','type'=>'checkbox'],
					'categories' => ['label'=>'category','type'=>'select','option'=>['','html','css','php','js','MongoDB'],'multiple'=>'multiple','class'=>'post-select']
				]
		]); ?>
	</section>
	<footer>
		<?php echo $this->Form->submit('Envoyer',['class'=>'btn-submit']); ?>
	</footer>
	<?php echo $this->Form->end(); ?>
</section>