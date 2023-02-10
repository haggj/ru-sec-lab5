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
}
else {
	echo "<ul>";
	echo "<li> <a href='/blog.php?file=dir/anatomy.html'>Human anatomy</a> </li> ";
	echo "<li> <a href='/blog.php?file=dir/completely_true_stuff.html'>Occult superstition</a></li> ";
	echo "<li> <a href='/blog.php?file=dir/non_fiction.html'>Fiction</a></li> ";
	echo "<li> <a href='/blog.php?file=dir/how_to_pass_as_human.html'>Applied method acting</a></li> ";
	echo "<li> <a href='/blog.php?file=dir/these_damn_fish_people.html'>Guide to stress free fishing</a></li> ";
	echo "<li> <a href='/blog.php?file=dir/top_5_places_to_summon_demons.html'>Top 5 travel destinations</a></li> ";
	echo "</ul>";	

	session_start();
	if(isset($_SESSION['user'])) {
		echo "<h2>Admin operation</h2>";

		if (isset($_POST["submit"])){
			$fileTmpPath = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['name'];
			$fileSize = $_FILES['file']['size'];
			$fileType = $_FILES['file']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
			echo "file name $fileName, file tmppath $fileTmpPath, file size $fileSize";

			$target_dir = "dir/";
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$uploadOk = 1;
			
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			
			if ($_FILES["file"]["size"] > 500000) {
				echo "Sorry, your file is too large.";
  				$uploadOk = 0;
			}

			if($uploadOk == 0){
				echo "Your file was not uploaded";
			} else {
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}

		}
		else {

		echo '
		<form method="post" action="blog.php" enctype="multipart/form-data" >
			<input type="file" name="file" id="file">
			  <input type="submit" name="submit">
		</form>';
		}
	}

}


?>

</body>
</html>
