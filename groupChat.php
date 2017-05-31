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
</head>
<body>
	<?php require("header.php"); ?>
	<style>li#group{background-color: #4CAF50;}</style>	
	<div class = "content">
		<h2>Select a group...</h2>
		<div id = "groups">
			<form method="post" action="groupTalk.php">
				<select name="activeGroup">
					<option disabled selected value> -- select a group -- </option>
					<?php fillOptions($_SESSION['genres'], $_SESSION['age']); ?>		
				</select>
				<button type="submit" name="showGroup" style="width: 100px;">Show</button>
			</form>	
		</div>
		<div id = "footer">
			<p>Blow Your Speakers: Your Music Community Hub</p>
		</div>
</body>
</html>



