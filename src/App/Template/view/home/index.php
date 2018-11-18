<?php 
$this->setTitle(' - framework');
$this->layout = 'test';
?>

<header class="home-cover">
	<div class="home-text">
		<span class="debug-php">&lt;?=</span><span class="debug-keyword"> __</span>(<span class="debug-text">"Hello World"</span>) <span class="debug-php">?&gt;</span>
	</div>
</header>
<section id="Index">
	<div class="layout-index">
		<div>
			<?php echo _('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, numquam?'); ?>
			<ul>
				<li><?php echo _('PHP version: ').PHP_VERSION; ?></li>
				<li><?php echo _('Mongodb driver: ').phpversion("mongodb"); ?></li>
				<li><?php echo _('GetText: ').phpversion("gettext"); ?></li>
				<li><?php echo _('Intl: ').phpversion("intl"); ?></li>
			</ul>
		</div>
		<div>
			<?php echo _('Laborum repellendus ducimus earum. Libero labore ducimus nulla architecto sapiente.'); ?>
		</div>
		<div>
			<?php echo _('Expedita hic quas vel vero culpa molestias itaque, quidem saepe. ');?>
		</div>
	</div>
</section>

