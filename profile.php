<!DOCTYPE html>
<html lang="english">
<head>
	<title>My account</title>
	<meta charset = "UTF-8">
	<link href = "style/style.css" rel = "stylesheet" type = "text/css" /> 
	<link href = "style/mainStyle.css" rel = "stylesheet" type = "text/css" />
	<script src="js/jquery-3.2.1.min.js"></script> 
</head>
<style>
	h2{
		text-align: left;
	}
</style>
<body>
	<?php require("header.php"); ?>
	<style>li#profile{background-color: #4CAF50;}</style>	
	<div class = "content">
		<div class = "messages">
			<h1>Your Profile</h1><br />
			<?php
				require('initMongo.php');
				$db = $client ->selectCollection ("blowyourspeakers", "users");
				$userQuery = array ("nickname" => $_SESSION['nick']); 
				$user = $db ->findOne($userQuery);
				$likes =  implode($user['genres'], ', ');
				echo "<h2><strong>Nickname:</strong> {$user['nickname']}</h2>";
				echo "<h2><strong>You like:</strong> {$likes}</h2>";
			?>
			<button onclick="location.href='editProfile.php';" style="width:150px;">Edit preferences</button>
		</div>	
	</div>
	<div id = "footer">
		<p>Blow Your Speakers: Your Music Community Hub</p>
	</div>
</body>
</html>

