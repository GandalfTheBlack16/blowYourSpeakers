<?php
	
	session_start();

	$nick = $_POST["nickname"];
	$password = $_POST["pass"];

	require('initMongo.php');

	$db = $client ->selectCollection ("blowyourspeakers", "users");
	$userQuery = array ("nickname" => $nick, "password" => $password);
	
	if ($db->count($userQuery) == 0){

		echo "<p>Username or Password wrong</p>";
		$client->close();
		header("Location: index.html");
	}
	else{

		if ($nick == "admin"){
			$_SESSION["nick"]= $nick;
			header("Location: admin.php");
		}
		else{

			$_SESSION["nick"]= $nick;
			$_SESSION["pass"]= $password;
			
			$cursor = $db ->find($userQuery);
			foreach ($cursor as $doc) {
				$_SESSION["genres"]= $doc["genres"];
			}

			$client->close();
			header("Location: globalChat.php");
		}
	}
	
?>