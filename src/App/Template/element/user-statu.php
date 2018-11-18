<?php $user = $this->Auth->getAuth(); ?>
<nav class="element-end">
	<ul id="UserInfo" class="user-panel user-panel-bottom">
	<?php if (empty($user)): ?>
		<li><?php echo $this->link('login', ['controller'=>'user','action'=>'login']);?></li>
		<li><?php echo $this->link('sign-up', ['controller'=>'user','action'=>'signUp']);?></li>
	<?php else: ?>
		<li><?php echo $this->link($user->login, ['controller'=>'profil','action'=>'index']);?></li>
		<li><?php echo $this->link('&hksearow;', ['controller'=>'user','action'=>'logout'],['title'=>'logout']);?> </li>
	<?php endif ?>
	</ul>
</nav>

<?php $this->startScript() ?>
<script type="text/javascript">
$(document).ready(function(){
	var panel = document.getElementById('UserInfo');
	var header = document.getElementById('Header');
	var pps = panel.getBoundingClientRect();
	var right = parseInt(window.innerWidth) - parseInt(pps.right) - 12;
	$( window ).scroll(function() {
		var doc = document.body;
		var top = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
		var pp = panel.getBoundingClientRect();
		var hp = header.getBoundingClientRect();
		if((pp.top<=0)&&(hp.bottom<=0)){
			$('.user-panel-bottom').removeClass('user-panel-bottom').addClass('user-panel-top');
			$('.user-panel-top').css('right',right+'px');
		}else{
			$('.user-panel-top').css('right',0);
			$('.user-panel-top').removeClass('user-panel-top').addClass('user-panel-bottom');
		}
	});
});
</script>
<?php $this->stopScript() ?>
