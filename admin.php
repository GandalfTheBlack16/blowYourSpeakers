<!DOCTYPE html>
<html lang="english">
<head>
	<title>Administration Page</title>
	<meta charset = "UTF-8">
	<link href = "style/style.css" rel = "stylesheet" type = "text/css" /> 
	<link href = "style/mainStyle.css" rel = "stylesheet" type = "text/css" />
	<script src="js/jquery-3.2.1.min.js"></script> 
</head>
<body>
	<?php require("header.php"); ?>	
	<div id = "content">
		<div id = "messages">
			<h3>Groups</h3>
			<?php
				require('initMongo.php');
				$db = $client ->selectCollection ("blowyourspeakers", "groups");
				//$userQuery = array ("to" => ""); //Buscamos en la coleccion los mensajes sin receptor (van dirigidos a todos)
				if ($db->count() == 0){
					echo "<p>Add new groups using the form below</p>";
					$client->close();
				}
				else{
					$cursor = $db ->find() -> sort(array('timestamp'=>1)); //utilizamos un cursor para procesar los resultados en orden cronologico descendiente 
					?>
					<table>
						<tr>
							<th>Group</th>
							<th>Genres</th>
							<th>Age range</th>
						</tr> 
						<?php foreach ($cursor as $doc) {
						
							echo "<tr>";
							echo "<td>{$doc['groupName']}</td>";
							echo "<td>{$doc['genres']}</td>";
							echo "<td>{$doc['ageRange']}</td>";
							echo "</tr>";
						}?>
						
					</table>"; <?php
				}
			?>
		</div>
		<div class="inputmsg" name="addGroupForm">
			<form method="post" action="admin.php">
				<label for="nameField">Group Name</label><input type="text" id = "nameField" name="group" style="width: 50%;" required/> 
				<select name="genre" required>
					<option disabled selected value> -- select musical taste -- </option>
					<option value="rock">Rock</option>
					<option value="pop">Pop</option>
					<option value="classic">Classical</option>
					<option value="elect">Electro</option>
					<option value="grunge">Grunge</option>
					<option value="metal">Metal</option>
				</select>
				<fieldset>
					<legend>Age Range:</legend>
					<label><b>Min. Age</b></label>
					<input type="number" name="minAge" min="16" max="84">
					<label><b>Max. Age</b></label>
					<input type="number" name="maxAge" min="17" max="85">
				</fieldset>

				<button type="submit" name="submitButton" style="width: 100px;">Add</button>
			</form>
		</div>
	</div>
	<?php include("footer.php"); ?>
</body>
</html>

<?php
	if (isset($_POST['submitButton']))
	{
		$db = $client-> selectCollection ("blowyourspeakers", "groups");
		$range = array("min" => $_POST['minAge'], "max" => $_POST['maxAge']);
		$userQuery = array("groupName" => $_POST['group'], "genres" => $_POST['genre'], "ageRange" => $range);
		try{
			$db->insert($userQuery);
			unset($_POST);
			header("Location: admin.php");
		}catch(MongoException $e){
			echo "<p>An error ocurs while loading messages. Please, refresh the page</p>";
		}
	}
?>

