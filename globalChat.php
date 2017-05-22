<html>
<head>
	<meta charset = "UTF-8">
	<link href = "style.css" rel = "stylesheet" type = "text/css" />
</head>
<body>
	<ul>
		<!-- <li>Coffee</li>
		<li>Tea</li>
		<li>Milk</li> -->
	</ul> 
</body>
</html>

<?php

	try{
		$client = new MongoClient();
	} catch(MongoException $e){
		echo "<p>Please, check Mongo DB server is started</p>"; 
	}

	$db = $client ->selectCollection ("blowyourspeakers", "messages");
	$userQuery = array ("to" => null); //Buscamos en la coleccion los mensajes 										sin receptor (van dirigidos a todos)
	
	if ($db->count($userQuery) == 0){
	
		echo "<p>NO MESSAGES</p>";
		$client->close();
	}
	else{
		$cursor = $db ->find($userQuery);
		foreach ($cursor as $doc) {
			echo "<li><strong>{$doc['from']}({$doc['date']}):</strong>{$doc['msg']}</li>";
		}
	}

?>