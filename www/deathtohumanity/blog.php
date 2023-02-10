<html>

<head>
<title>Wilbur Whateley & co blog</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<a href="/">Back</a>
<h1>Wilbur Whateley & co blog</h1> 
<?php
if (isset($_GET['file'])) {
        $file = $_GET['file'];	
	$file = file_get_contents($file);
	echo "$file";
	echo '<br /><a href="/blog.php">Back to blog index</a>';
}
else {


	$user = "wilburwhateley";
	$password = "verysecuresqlpassword12321312312312";
       	$database = "my_first_database";
       	$table = "blogs";
       	$db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
       	$query = "SELECT * FROM $table";
       	//$statement = $db->query($query);

	echo "<ul>";
	foreach($db->query($query) as $row) {
		$href = $row[2];
		$title = $row[1]; 
		echo "<li> <a href='/blog.php?file=dir/$href'>$title</a> </li> ";
  	}

	echo "</ul>";

}



?>

</body>
</html>
