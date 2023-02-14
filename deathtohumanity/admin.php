<html>
<head>
<title>Secret admin site</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<a href="/">Back</a>
<?php
ini_set('display_errors', 0);
session_start();
if(isset($_SESSION['user'])) {
	if(!isset($_POST["submit"])) {
		echo "<form action=\"admin.php\" method=\"post\" enctype=\"multipart/form-data\">
		Select html file to upload: <br />
		Title of blog post: <input type=\"text\" name=\"title\" id=\"title\"><br/>
		Blog post html: <input type=\"file\" name=\"file\" id=\"file\"><br/>
		<input type=\"submit\" value=\"Upload Blog post\" name=\"submit\">
		</form>";
	} else {
		$target_dir = "dir/";
		$fileName = $_FILES["file"]["name"];
		$target_file = $target_dir . basename($fileName);
		$uploadOk = 1;
		$fileExt = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$allowed = array('txt', 'text', 'html');
		if (!in_array($fileExt, $allowed)) {
			echo "-" . $fileExt . "-";
    		echo "Sorry, invalid file!!!!!!!!!!!!!!!.<br>";
			$uploadOk = 0;
		}
		
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
	
		if ($_FILES["file"]["size"] > 500000) {
 			echo "Sorry, your file is too large.";
  			$uploadOk = 0;
		}

		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {



				$user = getenv('DB_USER');
				$password = getenv('DB_PASSWORD');
				$database = "my_first_database";
				$table = "users";
				$db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
				$newTitle = $_POST['title'];

				$statement = $db->prepare('INSERT INTO blogs (blog_title, blog_file) VALUES (?, ?);');
				$statement->execute([$newTitle, $fileName]);

    			echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
  			} else {
	  			echo "Sorry, there was an error uploading your file.";
	  		}
		}
	}


} else { 

	echo "You are trying to access administrator functionality"; 

}
?>

</body>
</html>
