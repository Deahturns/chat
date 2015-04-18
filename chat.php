<?php include("modules/API.php");?>
<?php

	$room = $_GET['room'];

?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link href='http://fonts.googleapis.com/css?family=Oxygen:300' rel='stylesheet' type='text/css'>
	</head>

	<body>
		<div class="box">
			<span>
				<h2><?php echo $room;?></h2>
				<div class="convo">
				</div>
			</span>
			<div class="footer">
				<i>Your conversations are being scanned.</i>
			</div>
		</div>
	</body>

	<footer>
	</footer>
</html>