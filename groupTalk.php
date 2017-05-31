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
		<div class = "messages">
			<?php 
				include("initMongo.php"); 
				$id_group =  htmlspecialchars($_GET["idGroup"]);
				$db = $client->selectCollection("blowyourspeakers", "groups");
				$result = $db->findone(array("_id"=>$id_group));
				echo "<h3>Group Chat: {$name}</h3>";

				$db = $client->selectCollection("blowyourspeakers", "messages");
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

<?php
	if (isset($_POST['addMessage'])){
		include("initMongo.php");
		$db = $client->selectCollection("blowyourspeakers", "messages");
		$date = date("d-m-Y H:i");
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