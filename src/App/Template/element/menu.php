<nav id="Menu">
	<ul>
		<li><?php echo $this->link('home', ['controller'=>'Home','action'=>'index']);?></li>
		<li><?php echo $this->link('post', ['controller'=>'Post','action'=>'index']);?></li>
		<li><?php echo $this->link('user', ['controller'=>'User','action'=>'index']);?></li>
	</ul>
</nav>