<?php

	session_start();

	$db = new PDO("mysql:host=*.dev;dbname=chat;", "root", "tango255");

	function auth_room($room){
		global $db;

		$result = $db->query("SELECT * FROM rooms WHERE roomName='$room'");
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

	class message{
		var $id;
		var $text;
		var $room;
		var $nick;
		var $date;
		var $ip;

		function __construct($id){
			$this->id = $id;
		}

		function fetch_build(){
			global $db;

			$result = $db->query("SELECT * FROM messages WHERE messageID=$this->id");
			while(($row = $result->fetch()) != false){
				$this->id = $row['messageID'];
				$this->text = $row['messageText'];
				$this->room = $row['roomName'];
				$this->nick = $row['userNick'];
				$this->date = $row['messageDate'];
				$this->ip = $row['userIP'];
			}
		}

		function render(){
			?>
				<div class="msg">
					<?php echo "$this->nick: $this->text"; ?>
				</div>
			<?php
		}
	}


?>