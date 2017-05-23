<?php
	
	session_start();

	$email = $_POST["email"];
	$password = $_POST["pass"];

	try{
		$client = new MongoClient();
	} catch(MongoException $e){
		echo "<p>Please, check Mongo DB server is started</p>"; 
	}

	$db = $client ->selectCollection ("blowyourspeakers", "users");
	$userQuery = array ("email" => $email, "password" => $password);
	
	if ($db->count($userQuery) == 0){

		echo "<p>Email or Password wrong</p>";
		$client->close();
		header("Location: index.html");
	}
	else{

		$_SESSION["email"]= $email;
		$_SESSION["pass"]= $password;

		$cursor = $db ->find($userQuery);
		foreach ($cursor as $doc) {
			$_SESSION["nick"]= $doc["nickname"];
			$_SESSION["genres"]= $doc["genres"];
		}

		$client->close();
		echo "HOLA AXEL";
		header("Location: main.php");
	}
	
?>