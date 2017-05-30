<!DOCTYPE html>
<html>
<head>
	<title> New User </title>
	 <link rel="stylesheet" href="style/style.css">
	<meta charset = "UTF-8">
</head>
<body>

<h2>New Account on Blow Your Speakers!</h2>

<form action="newUser.php" method="POST" style="border:1px solid #ccc">
  <div class="container">

    <label><b>Nick</b></label>
    <input type="text" placeholder="Enter Nickname" name="nick" required>

    <label><b>Musical Tastes</b></label><br>

	 	<label for="rock">Rock</label>
	 	<input type="checkbox" name="taste[]" value="Rock" id="rock">

	 	<label for="pop">Pop</label>
	    <input type="checkbox" name="taste[]" value="Pop" id="pop">

	    <label for="classic">Classical</label>
	    <input type="checkbox" name="taste[]" value="Classical" id="classic">

	    <label for="elect">Electro</label>
	    <input type="checkbox" name="taste[]" value="Electro" id="elect">

	    <label for="grunge">Grunge</label>
	    <input type="checkbox" name="taste[]" value="Grunge" id="grunge">

	    <label for="metal">Metal</label>
	    <input type="checkbox" name="taste[]" value="Metal" id="metal"> <br>

	<label><b>Age</b></label><br>
	<input type="number" name="age" min="16" max="85">

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
    <!-- <input type="checkbox" checked="checked"> Remember me -->
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <div class="clearfix">
      <button onclick = "window.location.href='index.html'" class="cancelbtn">Cancel</button>
      <button type="submit" class="signupbtn">Sign Up</button>
    </div>
  </div>
</form>
<?php include("footer.php"); ?>
</body>
</html>

<?php 
	
	if (isset($_POST['nick']) && isset($_POST['taste']) && isset($_POST['age']) && isset($_POST['psw']) && isset($_POST['psw-repeat'])){
		
		$pass1 = $_POST['psw'];
		$pass2 = $_POST['psw-repeat'];
		$nick = $_POST['nick'];
		$age = $_POST['age'];
		$genres = $_POST['taste'];
		
		require ("initMongo.php");

		$db = $client->selectCollection("blowyourspeakers", "users");
		
		if ($pass1 == $pass2){

			$newUser = array ("nickname"=> $nick, "password"=> $pass1, "age" => $age ,"genres"=> $genres);

			try{
				$db->insert($newUser);
			} catch (MongoCursorException $e){

			}finally{

				$client->close();
				header("Location: index.html");
			}

		}
		else{

			echo "<p>Passwords dont conceed!</p>";
			unset($_POST);
		}

	}
?>
