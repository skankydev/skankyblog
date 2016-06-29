<?php $user = $this->Auth->getAuth(); ?>
<nav class="element-end">
	<ul id="UserInfo" class="user-panel user-panel-bottom">
	<?php if (empty($user)): ?>
		<li><?php echo $this->link('login', ['controller'=>'user','action'=>'login']);?></li>
	<?php else: ?>
		<li><?php echo $this->link($user->username, ['controller'=>'user','action'=>'view','params'=>[$user->username]]);?></li>
		<li><?php echo $this->link('logout', ['controller'=>'user','action'=>'logout']);?> </li>
	<?php endif ?>
	</ul>
</nav>

<?php $this->startScript() ?>
<script type="text/javascript">
$(document).ready(function(){
	var panel = document.getElementById('UserInfo');
	var header = document.getElementById('Header');
	$( window ).scroll(function() {
		var doc = document.body;
		var top = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
		var pp = panel.getBoundingClientRect();
		var hp = header.getBoundingClientRect();
		if((pp.top<=0)&&(hp.bottom<=0)){
			$('.user-panel-bottom').removeClass('user-panel-bottom').addClass('user-panel-top');
		}else{
			$('.user-panel-top').removeClass('user-panel-top').addClass('user-panel-bottom');
		}
		
	});
});
</script>
<?php $this->stopScript() ?>
