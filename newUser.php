<!DOCTYPE html>
<html>
<head>
	<title> New User </title>
	 <link rel="stylesheet" href="style/style.css">
	 <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
	<meta charset = "UTF-8">
</head>
<body>

<h2>New Account on Blow Your Speakers!</h2>

<form action="newUser.php" method="POST" style="border:1px solid #ccc">
  <div class="container">

    <label><b>Nick</b></label>
    <input type="text" placeholder="Enter Nickname" name="nick" required>

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

	<label><b>Age</b></label><br>
	<input type="number" name="age" min="16" max="85" required><br />

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
    <!-- <input type="checkbox" checked="checked"> Remember me -->
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <div class="clearfix">
      <button type="submit" name= "addUser"class="signupbtn">Sign Up</button>
      <button onclick = "window.location.href='index.php'" class="cancelbtn">Cancel</button>
    </div>
  </div>
</form>
<?php include("footer.php"); ?>
</body>
</html>

<?php 
	
	if (isset($_POST['addUser'])){

		$pass1 = $_POST['psw'];
		$pass2 = $_POST['psw-repeat'];
		$nick = $_POST['nick'];
		$age = $_POST['age'];
		if (isset($_POST['taste']))
			$genres = $_POST['taste'];
		
		require ("initMongo.php");

		$db = $client->selectCollection("blowyourspeakers", "users");
		
		if($db->count(array("nickname" => $nick)) > 0){ ?>
			<script type = "text/javascript">
				$( document ).ready(function() {
				    alert( "Already exist an user with that nick!" );
				});
			</script>
<?php   }
		else{

			if ($pass1 == $pass2){

				$newUser = array ("nickname"=> $nick, "password"=> $pass1, "age" => $age ,"genres"=> $genres);

				try{
					$db->insert($newUser);
				} catch (MongoCursorException $e){

				}finally{

					$client->close();
					header("Location: index.php");
				}

			}
			else{

				echo "<p>Passwords dont conceed!</p>";
				unset($_POST);
			}
		}

	}
?>
