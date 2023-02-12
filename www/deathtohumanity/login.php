<html>
<head>
<title>Log in to deathtohumanity.ru.tv.biz</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<a href="/">Back</a>
<h1>Log in</h1> 
<p>Our login form is verified as being secured by my uncle Zadok</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Name: <input type="text" name="fname">
  password: <input type="password" name="fpass">
  <input type="submit">
</form>


<?php
ini_set('display_errors', 0);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	session_start();
  // collect value of input field
	$loginusername = $_POST['fname'];
	$loginpassword = $_POST['fpass'];
  	if (empty($loginusername) || empty($loginpassword)) {
    		echo "You need to supply some credentials.";
  	} else {
		$user = "wilburwhateley";
		$password = "verysecuresqlpassword12321312312312";
		$database = "my_first_database";
		$db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);

		$statement = $db->prepare('SELECT * FROM users where user_name = ?');
		$statement->execute([$loginusername]);

		$result = $statement->fetchAll();
		if($result) {
			if(password_verify($loginpassword, $result[0][2])){
			$userid = $result[0][0];
			$username = $result[0][1];
			$_SESSION['user'] = $username;
			echo "<p> You are now logged in <strong>$username</strong></p>"; 
			echo "<p> You can now proceed to view your <a href='messages.php'>messages</a></p>";
				exit;
		}
			
		}

		echo "<p>Invalid login information. If your login information is lost, please let me know by mail at 13 Barrow rd. Dunwich Massachusetts</p>"; 
		unset($_SESSION['user']);
		session_destroy();
		exit;
  	}
}
?>

</body>
</html>
