<html>
<head>
<title>Secret admin site</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<a href="/">Back</a>
<?php
if(isset($_COOKIE['logged_in'])) {
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
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
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



				$user = "wilburwhateley";
				$password = "verysecuresqlpassword12321312312312";
				$database = "my_first_database";
				$table = "users";
				$db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
				$newTitle = $_POST['title'];
				$db->query("INSERT INTO my_first_database.blogs (blog_title, blog_file) VALUES ('$newTitle', '$fileName'); ");


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
