<?php

	session_start();

	$db = new PDO("mysql:host=*.dev;dbname=chat;", "root", "tango255");

	

	function logout(){
		unset($_SESSION['userNick']);
		unset($_SESSION['userIP']);
	}

	function login($nick, $room){
		global $db;

		$_SESSION['userNick'] = $nick;
		$_SESSION['userIP'] = get_user_IP();

		
		$db->query("INSERT INTO rooms (roomName) VALUES ('$room')");

		return "chat.php?room=$room";
	}

	function is_loggedin(){
		return isset($_SESSION['userIP']);
	}

	function get_user_IP(){
	    $client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

	    if(filter_var($client, FILTER_VALIDATE_IP)){
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP)){
	        $ip = $forward;
	    }
	    else{
	        $ip = $remote;
	    }

	    return $ip;
	}


?>