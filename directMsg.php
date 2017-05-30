<!DOCTYPE html>
<html lang="english">
<head>
	<title>Direct Messages</title>
	<meta charset = "UTF-8">
	<link href = "style/style.css" rel = "stylesheet" type = "text/css" /> 
	<link href = "style/mainStyle.css" rel = "stylesheet" type = "text/css" />
	<script src="js/jquery-3.2.1.min.js"></script> 
</head>
<body>
	<?php require("header.php"); ?>
	<style>li#direct{background-color: #4CAF50;}</style>	
	<div class = "content">
		<div id = "messages">
			<h3>Friendly Chat: Talk with your best friends</h3>
			<?php
				require('initMongo.php');
				$db = $client ->selectCollection ("blowyourspeakers", "messages");
				$userQuery = array ("to" => $_SESSION['nick']); //Buscamos en la coleccion los mensajes cuyo receptor es el propio usuario loggeado
				if ($db->count($userQuery) == 0){
					echo "<p>NO MESSAGES</p>";
					$client->close();
				}
				else{
					$cursor = $db ->find($userQuery) -> sort(array('date'=>-1)); //utilizamos un cursor para procesar los resultados en orden cronologico descendiente 
					echo "<ul>";
					foreach ($cursor as $doc) {
					
						echo "<li><p><strong>FROM:{$doc['from']} ({$doc['date']}):</strong> {$doc['msg']}</p></li>";
					}
					echo "</ul>";
				}
			?>
		</div>	
		

		<div class="inputmsg" name="insertForm">
			<form method="post" action="directMsg.php">
				<label>TO: </label><input type="text" name="to" style="width: 70%;" required/>
				<input type="text" name="msg" style="width: 70%;" required/>
				<button type="submit" name="submitButton" style="width: 100px;">Send</button>
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
		$db = $client->selectCollection ("blowyourspeakers", "messages");
		$date = date("d-m-Y H:i");
		$userQuery = array ("to" => $_POST['to'], "from" => $_SESSION['nick'], "msg" => $_POST['msg'], "date" => $date);
		try{
			$db->insert($userQuery);
			unset($_POST);
			header("Location: directMsg.php");
		}catch(MongoException $e){
			echo "<p>An error ocurs while loading messages. Please, refresh the page</p>";
		}
	}
?>

