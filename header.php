<?php 
	session_start();
?>
<style>
	ul {
	    list-style-type: none;
	    margin: 0;
	    padding: 0;
	    overflow: hidden;
	}
	li a{
		display: block;
    	color: white;
  	  	text-align: center;
    	padding: 14px 16px;
   		text-decoration: none;	
	}
	li a:hover {
	   
	    background-color: #0e0785;
	}

	div#navBar{
		margin: 20px 10px 20px 30px;
		float: left;
		width: 40%;
	}
	p{
		font-size: 16px;
	}
</style>

<!DOCTYPE HTML>
<html lang="english">
	<head>
		<meta charset= "UTF-8" />
		<script src="jquery-3.2.1.min.js"></script> 
	</head>
	<body>
		<div id = "header">
			<div id="image" style="float: left; margin: auto; padding-top: 0">
				<img src="img/logo.png" alt="logo" style="height: 90px; margin-top: 0;"/>
			</div>	
			<div id ="navBar">
				<ul>
					<li id="global"><a href="globalChat.php">Global Messages</a></li>
					<li id="direct"><a href="directMsg.php">Private Zone</a></li>
					<li id="group"><a href="groupChat.php">My Groups</a></li>
					<li id="profile"><a href="profile.php">About me</a></li>
				</ul> 
			</div>
			<div id ="welcome">
				<p> Logged as, <?php echo "{$_SESSION['nick']}";?> </p>
			</div>
			<div id="logout">
				<button type="button" class = "btn" onclick="window.location.href='logout.php'">Log out</button> 
			</div>
		</div>
	</body>
</html>