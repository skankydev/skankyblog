<?php $this->setTitle('edit post'); ?>
<section id='Post'>
	<header><h1>Edit Post</h1></header>
	<?= $this->Form->start($post); ?>
	<section>
		<?= $this->Form->fieldset([
			'fieldset'=> ['class'=>'fieldset-post'],
			'legend'  => ['content'=>'edite a post','class'=>'legend-post'],
			'input'   => [
					'_id'        => ['type' =>'hidden'],
					'name'       => ['label'=>'name'],
					'slug'       => ['label'=>'slug'],
					'content'    => [
						'label'=>'content',
						'type'=>'Wysiwyg',
						'construct'=>[
							'img'=>[
								'media' => $post->media,
								'uploadLink'=> $this->request->url(['action'=>'upload','params'=>['slug'=>$post->slug]])
							],
							'link'=>true,
							'color'=>true,
							'title'=>true,
						]
					],
					'tags'       => ['label'=>'tags', 'labelAttr'=>['class'=>'tags-label'],'type'=>'select','option'=>$tags,'multiple'=>'checkbox','attr'=>['class'=>'checkbox']],
					'online'     => ['label'=>'online', 'type'=>'checkbox'],
					'categories' => ['label'=>'category', 'type'=>'select','option'=>['','html','css','php','js','MongoDB'],'class'=>'post-select']
				]
		]); ?>
	</section>
	<footer>
		<?= $this->Form->submit('Envoyer',['class'=>'btn-submit']); ?>
	</footer>
	<?= $this->Form->end(); ?>
</section>
