<!DOCTYPE html>
<html>
<head>
	<title> New User </title>
	 <link rel="stylesheet" href="style.css">
	<meta charset = "UTF-8">
</head>
<body>

<h2>New Account on Blow Your Speakers!</h2>

<form action="newUser.php" method="POST" style="border:1px solid #ccc">
  <div class="container">
    <label><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label><b>Nick</b></label>
    <input type="text" placeholder="Enter Nickname" name="nick" required>

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

</body>
</html>

<?php 
	
	if (isset($_POST['email'])){
		
		$email = $_POST['email'];
		$pass1 = $_POST['psw'];
		$pass2 = $_POST['psw-repeat'];
		$nick = $_POST['nick'];
		$genres = "";
		
		try{
			$mc = new MongoClient();
		}catch(MongoException $e){
			echo "<p>Please, check Mongo DB server is started</p>";
		}
		$db = $mc->selectCollection("blowyourspeakers", "users");
		
		if ($pass1 == $pass2){

			$newUser = array ("email"=> $email, "password"=> $pass1, "nickname"=> $nick, "genres"=> $genres);

			try{
				$db->insert($newUser);
			} catch (MongoCursorException $e){

				echo "<p>You're already registered!</p>";
			}finally{

				$mc->close();
				header("Location: index.html");
			}

		}
		else{

			echo "<p>Passwords dont conceed!</p>";
			unset($_POST);
		}

	}
?>
