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
	<div class = "container">
		<div id = "left">
			<h3>Groups</h3>
			<?php
				require('initMongo.php');
				$db = $client ->selectCollection ("blowyourspeakers", "groups");
				if ($db->count() == 0){
					echo "<p>Add new groups using the form below</p>";
					$client->close();
				}
				else{
					$cursor = $db ->find() -> sort(array('timestamp'=>1)); //utilizamos un cursor para procesar los resultados en orden cronologico descendiente 
					?>
					<table>
						<tr>
							<th>ID</th>
							<th>Group</th>
							<th>Genres</th>
							<th>Age range</th>
						</tr> 
						<?php foreach ($cursor as $doc) {
						
							$range = $doc['ageRange'];
							$ageRange = "{$range['min']}" . " - " . "{$range['max']}";
							echo "<tr>";
							echo "<td>{$doc['_id']}</td>";
							echo "<td>{$doc['groupName']}</td>";
							echo "<td>{$doc['genres']}</td>";
							echo "<td>{$ageRange}</td>";
							echo "</tr>";
						}?>
						
					</table> <?php
				}
			?>
		</div>
		<div id="rigth" name="addGroupForm">
			<form method="post" action="admin.php">
				<label for="nameField">Group Name</label><input type="text" id = "nameField" name="group" style="width: 50%;" required/> 
				<select name="genre" required>
					<option disabled selected value> -- select musical taste -- </option>
					<option value="Rock">Rock</option>
					<option value="Pop">Pop</option>
					<option value="Classic">Classical</option>
					<option value="Electro">Electro</option>
					<option value="Grunge">Grunge</option>
					<option value="Metal">Metal</option>
				</select>
				<fieldset>
					<legend>Age Range:</legend>
					<label><b>Min. Age</b></label>
					<input type="number" name="minAge" min="16" max="84"><br />
					<label><b>Max. Age</b></label>
					<input type="number" name="maxAge" min="17" max="85">
				</fieldset>

				<div class="clearfix" style="margin-left: 30px;">
					<button type="submit" name="submitButton" class="signupbtn">Add</button>
				</div>
			</form>
		</div>
	</div>
	<div id = "footer">
		<p>Blow Your Speakers: Your Music Community Hub</p>
	</div>
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

