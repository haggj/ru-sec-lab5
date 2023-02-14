<html>
<head>
<link rel="stylesheet" href="style.css">
</head>


<body>
<?php
ini_set('display_errors', 0);
session_start();
if(!isset($_SESSION['user'])) {


	echo "<p>You need an account to view this page. <a href='login.php'>Go to login</a></p>";
	echo "<p>If you do not have an account but you should, let me know by mail at 13 Barrow rd. Dunwich Massachusetts. </p>";
	echo "<p>If you stumbled on this site by accident, congratulations! You have won an exclusive all costs covered trip to Dunwich Massachusetts for a luxury dinner with my brother and me!";
	echo "Make your way to 13 Barrow rd in Dunwich and knock on the door of the guest shed outside the main building. Do not tell anyone where you are going. This is an exclusive and much sought ";
	echo "after prize. Do not bring a +1. Come alone. Please do not use soap made from almonds before making your way to the dinner, as I do not like the taste. </p>";
	echo "<h3>Come alone, do not tell anyone where you are going </h3>";


} else {
	$user = getenv('DB_USER');
	$password = getenv('DB_PASSWORD');
	$database = "my_first_database";
	$db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
	$query = "SELECT * FROM messages m join users u on m.userID = u.user_id";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	if(!$result) {
		echo "no es bueno";
		exit;
	} else {

		foreach($result as $message){
			echo "<div>";
			echo "$message[4] says: \"$message[2]\"";
			echo "<div>";
		}

	}
}
?>
</body>
</html>
