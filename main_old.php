<?php 
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Main</title>
	<meta charset = "UTF-8">
	<!-- <link href = "style.css" rel = "stylesheet" type = "text/css" /> -->
</head>
<body>
	<div id = "header">
		<div id="image" style="float: left; margin: auto; padding-top: 0">
			<img src="img/logo.png" alt="logo" style="height: 90px; margin-top: 0;"/>
		</div>
		<div id ="welcome">
			<p> Welcome, <?php echo "{$_SESSION['nick']}";?> </p>
		</div>
		<div id="logout">
			<button type="button" class = "btn" onclick="window.location.href='logout.php'">Log out</button> 
		</div>
	</div>
	<div id = "content">
		<div id = "leftPan">
			<h2>Globlal chat</h2>
			<?php include ("globalChat.php") ?>
			<div class="inputmsg">
				<form method="post" action="newGlobalChat.php">
					<input type="text" name="msg" style="width: 70%;" /> <button type="submit" style="width: 100px;"><-</button>

				</form>
			</div>
		</div>
		<div id = "centralPan">
			<h2>Direct msg</h2>
			<?php include ("directMsg.php") ?>
		</div>
		<div id = "rightPan">
			<h2>Groups</h2>
			<?php include ("groupChat.php") ?>
		</div>
	</div>
	<div id = "footer">
		<p>Blow Your Speakers: Your Music Community Hub</p>
	</div>
</body>
</html>
