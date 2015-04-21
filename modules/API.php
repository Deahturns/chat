<?php

	session_start();

	$db = new PDO("mysql:host=localhost;dbname=chat;", "root", "tango255");

	function random_color(){
		$colors = explode(",","aqua,black,blue,fuchsia,gray,green,lime,maroon,navy,olive,orange,purple,red,silver,teal,white,yellow");
		return $colors[rand(0, count($colors))];
	}

	function room_latest(){
		global $db;

		$result = $db->query("SELECT * FROM `rooms` ORDER BY `roomDate` DESC LIMIT 1");
		while(($row = $result->fetch()) != false){
			return $row['roomName'];
		}
	}

	function auth_room($room){
		global $db;

		$result = $db->query("SELECT * FROM `rooms` WHERE `roomName`='$room'");
		$count = 0;
		while(($row = $result->fetch()) != false){
			$count++;
		}

		if($count < 1){
			?>
				<script> window.location.href="index.php"; </script>
			<?php
		}
	}	

	function logout(){
		unset($_SESSION['userNick']);
		unset($_SESSION['userIP']);
		?>	
			<script> window.location.href="index.php"; </script>
		<?php
	}

	function login($nick, $room){
		global $db;

		$_SESSION['userNick'] = $nick;
		$_SESSION['userIP'] = get_user_IP();

		if(substr_count($nick, "<") > 0){
			return "index.php";
		}
		if(substr_count($room, "<") > 0){
			return "index.php";
		}

		
		$db->query("INSERT INTO `rooms` (roomName) VALUES ('$room')");

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

	class message{
		var $id;
		var $text;
		var $room;
		var $nick;
		var $date;
		var $ip;
		var $color;

		function __construct($id){
			$this->id = $id;
		}

		function fetch_build(){
			global $db;

			$result = $db->query("SELECT * FROM `messages` WHERE `messageID`=$this->id");
			while(($row = $result->fetch()) != false){
				$this->id = $row['messageID'];
				$this->text = $row['messageText'];
				$this->room = $row['roomName'];
				$this->nick = $row['userNick'];
				$this->date = $row['messageDate'];
				$this->ip = $row['userIP'];
				$this->color = $row['messageColor'];
			}
		}

		function render(){
			$nick = $this->nick;
			$msg = strip_tags($this->text);
			?>
				<div class="msg">
					<?php echo "<font color='blue'>$nick</font>: $msg"; ?>
				</div>
			<?php
		}
	}


?>
