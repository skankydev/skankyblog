<section id="Message-List">
<?php if (isset($messages)): ?>

	<?php foreach ($messages as $message): ?>
		<section>
			<header><?php echo $message->author; ?></header>
			<section><?php echo $message->message; ?></section>
			<footer>
			<?php 
				//TO DO un helper pour les date
				//le helper ne poura surment pas etre appeler va faloir tester
				/*$date = $message->created;
				$myDate = new DateTime();
				$ts = (int)$date->__toString();
				$myDate->setTimestamp($ts);
				$tz = new DateTimeZone('Europe/Paris');
				$myDate->setTimezone($tz);
				echo $myDate->format('H:i:s d-m-Y');*/
			?>
			</footer>
		</section>
	<?php endforeach ?>
<?php endif ?>
</section>

