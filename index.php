<?php include("modules/API.php");?>
<!DOCTYPE html>
<html id="chat-login">
	<head>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link href='http://fonts.googleapis.com/css?family=Oxygen:300' rel='stylesheet' type='text/css'>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>
		<div class="box">
			<span>
				<h2>Chat</h2>
				<form method="post">
					<input class="intext" type="text" name="chat_nick" placeholder="Nickname">
					<input class="intext" type="text" name="chat_roomname" placeholder="Chatroom">
					<input class="btn btn-emerald" type="submit" name="chat_enter" value="Enter">
				</form>
				<?php

					if(isset($_POST['chat_enter'])){
						$href = login($_POST['chat_nick'], $_POST['chat_roomname']);
						echo "<script>window.location='$href';</script>";
					}

				?>
			</span>
			<div class="footer">
				<i>Your conversations are being saved.</i>
			</div>
		</div>
	</body>

	<footer>
	</footer>
</html>