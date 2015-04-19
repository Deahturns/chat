<?php
	include("../modules/API.php");

	$room = $_POST['roomName'];

	$result = $db->query("SELECT messageID FROM messages WHERE messages.roomName='$room'");	
	while(($row = $result->fetch()) != false){
		$msg = new Message($row['messageID']);
		$msg->fetch_build();
		$msg->render();
	}


?>