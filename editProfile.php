<!DOCTYPE html>
<html lang="english">
<head>
	<title>My account</title>
	<meta charset = "UTF-8">
	<link href = "style/style.css" rel = "stylesheet" type = "text/css" /> 
	<link href = "style/mainStyle.css" rel = "stylesheet" type = "text/css" />
	<script src="js/jquery-3.2.1.min.js"></script> 
</head>
<style>
	h2{
		text-align: left;
	}
</style>
<body>
	<?php require("header.php"); ?>
	<style>li#profile{background-color: #4CAF50;}</style>	
	<div class = "content">
		<div class = "messages">
			<form action="editProfile.php" method="POST">

				<label><b>Musical Tastes</b></label><br>

				<input type="checkbox" name="taste[]" value="Rock" id="rock">
			 	<label for="rock">Rock</label><br />
			    <input type="checkbox" name="taste[]" value="Pop" id="pop">
			 	<label for="pop">Pop</label><br />
			    <input type="checkbox" name="taste[]" value="Classical" id="classic">
			    <label for="classic">Classical</label><br />
			    <input type="checkbox" name="taste[]" value="Electro" id="elect">
			    <label for="elect">Electro</label><br />
			    <input type="checkbox" name="taste[]" value="Grunge" id="grunge">
			    <label for="grunge">Grunge</label><br />
			    <input type="checkbox" name="taste[]" value="Metal" id="metal"> 
			    <label for="metal">Metal</label><br />

		        <button type="submit" name="editOk" >Edit</button>	
		    </form>
		</div>	
	</div>
	<div id = "footer">
		<p>Blow Your Speakers: Your Music Community Hub</p>
	</div>
</body>
</html>

<?php
	
	if (isset($_POST['editOk'])){

		include("initMongo.php");
		$db = $client ->selectCollection ("blowyourspeakers", "users");
		$newData = array('$set' => array("genres" => $_POST['taste']));
		$db->update(array("nickname"=>$_SESSION['nick']), $newData);
		$client->close();
		header("Location: profile.php");
	}
?>