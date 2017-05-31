<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Blow Your Speakers!</title>
	<meta charset = "UTF-8">
	<link href = "style/style.css" rel = "stylesheet" type = "text/css" />
	<script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
</head>
<body id = "index">
	<div id = "log">
		<div class="login">
			<div class="login-form">
				<form method = "post" action="index.php">
					<div class="control-group">
						<input type="text" class="login-field" value="" placeholder="Username" id="login-name" name="nickname">
						<label class="login-field-icon fui-user" for="login-name"></label>
					</div>

					<div class="control-group">
						<input type="password" class="login-field" value="" placeholder="password" id="login-pass" name="pass">
						<label class="login-field-icon fui-lock" for="login-pass"></label>
					</div>

					<button type = "submit" name="login" class="btn btn-primary btn-large btn-block">login</button>
				</form>		
			</div>
		</div>
		<p style="color: white">Have no account? <a href = "newUser.php">Register</a></p>
	</div>
	<div id = "footer">
		<p>Blow Your Speakers: Your Music Community Hub</p>
	</div>
</body>
</html>

<?php
	if(isset($_POST['login'])){

		$nick = $_POST["nickname"];
		$password = $_POST["pass"];

		include('initMongo.php');

		$db = $client ->selectCollection ("blowyourspeakers", "users");
		$userQuery = array ("nickname" => $nick, "password" => $password);
		
		if ($db->count($userQuery) == 0){ ?>

			<script type = "text/javascript">
				$( document ).ready(function() {
				    alert( "Username or password wrong!" );
				});
			</script>
<?php
			$client->close();
		}
		else{

			if ($nick == "admin"){
				$_SESSION["nick"]= $nick;
				header("Location: admin.php");
			}
			else{

				$_SESSION["nick"]= $nick;
				$_SESSION["pass"]= $password;
				
				$cursor = $db ->find($userQuery);
				foreach ($cursor as $doc) {
					$_SESSION["genres"]= $doc["genres"];
					$_SESSION["age"] = $doc["age"];
				}

				$client->close();
				header("Location: globalChat.php");
			}
		}
	}	
?>