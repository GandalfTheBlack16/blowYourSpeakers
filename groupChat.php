<?php
	
	/**Función que rellena dinamicamente la lista desplegable para que el usuario pueda elegir el grupo con el que interactuar**/
	function fillOptions($genres, $age){

		include("initMongo.php");
		$db = $client->selectCollection("blowyourspeakers", "groups");
		$cursor = $db -> find();
		foreach ($cursor as $key) {
			$range = $key['ageRange'];
			if (in_array($key['genres'] , $genres) && $age >= $range['min'] && $age <= $range['max'])
			{
				echo "<option value='".$key['_id']."'>".$key['groupName']."</option>";
			}
		}
		$client->close();
	}
?>

<!DOCTYPE html>
<html lang="english">
<head>
	<title>Group Chat</title>
	<meta charset = "UTF-8">
	<link href = "style/style.css" rel = "stylesheet" type = "text/css" /> 
	<link href = "style/mainStyle.css" rel = "stylesheet" type = "text/css" />
	<script src="js/jquery-3.2.1.min.js"></script> 
</head>
<body>
	<?php require("header.php"); ?>
	<style>li#group{background-color: #4CAF50;}</style>	
	<div class = "content">
		<div id = "groups">
			<form method="post" action="groupChat.php">
				<select name="activeGroup">
					<option disabled selected value> -- select a group -- </option>
					<?php fillOptions($_SESSION['genres'], $_SESSION['age']); ?>		
				</select>
				<button type="submit" name="showGroup" style="width: 100px;">Show</button>
			</form>	
		</div>
		<div class = "messages">
			<h3>Group Chat: Share everything with your mates</h3>
			<?php

				if (isset($_POST['showGroup'])  && !isset($_POST['addMessage'])){
					include("initMongo.php");
					$db = $client->selectCollection("blowyourspeakers", "messages");
					$id_group = $_POST['activeGroup'];
					//$_SESSION['activeGroup'] = $id_group;
					$userQuery = array("to" => $id_group);
					$cursor = $db -> count($userQuery);
					if ($cursor == 0)
					{
						echo "<p>NO MESSAGES IN THIS GROUP</p>";
					}
					else{
						echo "<ul>";
						$cursor = $db -> find($userQuery);
						foreach ($cursor as $key) {

							echo "<li><p><strong>{$doc['from']} ({$doc['date']}):</strong> {$doc['msg']}</p></li>";
						}
						echo "</ul>";
					}
					$client->close();
				}

				if (isset($_POST['showGroup']) && isset($_POST['addMessage'])){
					include("initMongo.php");
					$db = $client->selectCollection("blowyourspeakers", "messages");
					$date = date("d-m-Y H:i");
					echo "<p>{$id_group}</p>";
					$userQuery = array ("to" => $id_group, "from" => $_SESSION['nick'], "msg" => $_POST['msg'], "date" => $date);
					try{
						$db->insert($userQuery);
						unset($_POST);
						$client->close();
					}catch(MongoException $e){
						echo "<p>An error ocurs while loading messages. Please, refresh the page</p>";
					}
				}
			?>
			<div class="inputmsg" name="insertForm">
				<form method="post" action="groupChat.php">
					<input type="text" name="msg" style="width: 70%;" required/> 
					<button type="submit" name="addMessage" style="width: 100px;">Send</button>
				</form>
			</div>
		</div>
</body>
</html>



