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
		<div>
			<button onclick="location.href='groupChat.php';" style="width:150px;">More chats</button>
		</div>
		<div class = "messages">
			<?php 
				
				if (isset($_POST['showGroup'])){
					$id_group = $_POST["activeGroup"];
					$_SESSION['id'] = $id_group;
				} 

				include("initMongo.php"); 
				$db = $client->selectCollection("blowyourspeakers", "groups");
				$userQuery = array("_id" => new MongoId($_SESSION['id']));
				$result = $db->findOne($userQuery);
				echo "<h3>Group Chat: {$result['groupName']}</h3>";
		
				$db = $client->selectCollection("blowyourspeakers", "messages");
				$userQuery = array("to" => $_SESSION['id']);
				$cursor = $db -> count($userQuery);
				if ($cursor == 0)
				{
					echo "<p>NO MESSAGES IN THIS GROUP</p>";
				}
				else{
					echo "<ul>";
					$cursor = $db -> find($userQuery);
					foreach ($cursor as $doc) {

						echo "<li><p><strong>{$doc['from']} ({$doc['date']}):</strong> {$doc['msg']}</p></li>";
					}
					echo "</ul>";
				}
				$client->close();
			?>
			<div class="inputmsg" name="insertForm">
				<form method="post" action="groupTalk.php">
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
		$userQuery = array("to" => $_SESSION['id'], "from" => $_SESSION['nick'], "msg" => $_POST['msg'], "date" => $date);
		try{
			$db->insert($userQuery);
			unset($_POST);
			header("Location: groupTalk.php");
		}catch(MongoException $e){
			echo "<p>An error ocurs while loading messages. Please, refresh the page</p>";
		}
	}
?>