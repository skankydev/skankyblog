<?php $this->setTitle(' - framework'); ?>
<section id="Index">
	<header>
		
	</header>
	<section>
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
	<footer>
		
	</footer>
</section>

<?php $this->startScript(); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#Index').height($(window).height()-$('#Header').height());
	$('#Menu').addClass('fix-menu');
	$('#Header').addClass('fix-header');
	$( "<section id=\"Ouah-ca-bouge\"><div class=\"joli-message\"><span class=\"debug-php\">&lt;?php</span> <span class=\"debug-keyword\">echo _</span>(<span class=\"debug-text\">\"Hello World\"</span>); <span class=\"debug-php\">?&gt;</span></div></section>" ).insertAfter( "#Header" );
	var befor = (window.pageYOffset || document.body.scrollTop);

	var maxY = $(window).height();
	var tmp = $('#Header').height() + $('#Menu').height();

	var palier = $(window).height()-tmp;
	tmp = $(window).height() / 2;
	$('.joli-message').css('top',tmp+'px');
	$('#Ouah-ca-bouge').css('height',maxY+'px');
	
	$( window ).scroll(function(event) {
		var top = (window.pageYOffset || document.body.scrollTop);
		offset = top-befor;
		var pos = $('#Ouah-ca-bouge').css('background-position');
		pos = pos.split(' ');
		pos = parseInt(pos[1]);
		pos +=offset;
		$('#Ouah-ca-bouge').css('background-position','0px '+pos+'px');
		if(top>palier){
			var m = maxY - $('#Header').height() - $('#Menu').height();
			var h = maxY - $('#Header').height();

			$('.fix-header').css('top',h+'px');
			$('.fix-menu').css('top',m+'px');
			$('#Header').removeClass('fix-header').addClass('scroll-header');
			$('#Menu').removeClass('fix-menu').addClass('scroll-menu');
			$('#Ouah-ca-bouge').css('background-position','0px 0px');
		}else{
			var m = 0;
			$('.scroll-menu').css('top',m+'px');
			var h = 0 + $('#Menu').height();
			$('.scroll-header').css('top',h+'px');
			$('#Header').removeClass('scroll-header').addClass('fix-header');
			$('#Menu').removeClass('scroll-menu').addClass('fix-menu');

		}
		befor = top;
	});
});
</script>
<?php $this->stopScript(); ?>
