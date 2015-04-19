<?php include("modules/API.php");?>
<?php

	$room = $_GET['room'];
	auth_room($room);


?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link href='http://fonts.googleapis.com/css?family=Oxygen:300' rel='stylesheet' type='text/css'>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
	</head>

	<body>
		<div class="box" id="box-chat">
			<span>
				<h2><?php echo $room;?></h2>
				<p>Logged in as: <?php echo $_SESSION['userNick']; ?></p>
				<div class="convo" id="convo">
				</div>
				<form method="post" id="message-box">
					<input class="intext" type="text" name="msg" id="msg" placeholder="Message...">
				</form>
				<script type="text/javascript">
					$("#message-box").submit(function(event){
						event.preventDefault();
						var text = $("#msg").val();
						
						var request = $.ajax({
							type:"post",
							cache:false,
							url:"apps/convo_send.php",
							data:{userIP: "<?php echo $_SESSION['userIP']; ?>", room: "<?php echo $room; ?>", message: text, nick: "<?php echo $_SESSION['userNick']; ?>"}
						});
						$("#msg").val("");
					});
				</script>
			</span>
			<div class="footer">
				<i>Your conversations are being saved.</i>
				<form method="post" style="display:inline;">
					<input type="submit" name="logout" value="Logout">
				</form>
				<?php

					if(isset($_POST['logout'])){
						logout();
					}

				?>
			</div>
		</div>
	</body>

	<footer>
		<script type="text/javascript">
			setInterval(function(){
				var request = $.ajax({
					type:"post",
					cache:false,
					url:"apps/convo_fetch.php",
					data: {roomName:"<?php echo $room; ?>"}
				});

				request.done(function(data){
					$(".convo").html(data);
				});

				var auth = $.ajax({
					type:"post",
					cache:false,
					url:"apps/auth.php"
				});

				auth.done(function(data){
					if(data == "NO"){
						window.location.href="index.php";
					}
				});

				var objDiv = document.getElementById("convo");
				objDiv.scrollTop = objDiv.scrollHeight;
			},60);
		</script>
	</footer>
</html>