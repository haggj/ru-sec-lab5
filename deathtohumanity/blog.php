<html>

<head>
<title>Wilbur Whateley & co blog</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<a href="/">Back</a>
<h1>Wilbur Whateley & co blog</h1> 
<?php
ini_set('display_errors', 0);
if (isset($_GET['file']) && !empty($_GET['file'])) {

	$file = "dir/" . basename($_GET['file']);
	if (file_exists($file)) {
	$file = file_get_contents($file);
	echo "$file";
	} else {
		echo "Not found";
	}
	
	echo '<br /><a href="/blog.php">Back to blog index</a>';
}
else {


		$user = getenv('DB_USER');
		$password = getenv('DB_PASSWORD');
       	$database = "my_first_database";
       	$table = "blogs";
       	$db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
       	$query = "SELECT * FROM $table";
       	//$statement = $db->query($query);

	echo "<ul>";
	foreach($db->query($query) as $row) {
		$href = $row[2];
		$title = $row[1]; 
		echo "<li> <a href='/blog.php?file=$href'>$title</a> </li> ";
  	}

	echo "</ul>";

}



?>

</body>
</html>
