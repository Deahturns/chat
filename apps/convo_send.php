<?php

	include("../modules/API.php");

	$ip = $_POST['userIP'];
	$room = $_POST['room'];
	$message = $_POST['message'];
	$nick = $_POST['nick'];

	$db->query("INSERT INTO messages (messageText, userNick, userIP, roomName) VALUES('$message', '$nick', '$ip', '$room')");


?>