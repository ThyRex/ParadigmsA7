<?php
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();

if(!isset($_SESSION['name'])){
	$_SESSION['name'];
}
if(!isset($_SESSION['email'])){
	$_SESSION['email'];
}

?>
<html>
<body>
<head><title>Thy's Bad DropBox!</title></head>
<h1>Thy's Bad DropBox</h1>
<br>
<?php
echo"Hello, ". $_SESSION['name']."!" . "<br>";
echo"Your email address is " . $_SESSION['email']."." ."<br>";
?>
<br>
<form name  = "logoutForm" action = "index.php" method = "post">
   <input type = "submit" name = "exit" value = "Logout" />
</form>

<form method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php
if(isset($_POST["submit"])){
	$target_dir = $_SESSION['name']. "/";
	$oldmask = umask(0);
	if(!is_dir($target_dir)){
		if(!mkdir($target_dir)){
			die("Error: Failed to make folder.");
		}
	}
	umask($oldmask);

	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . "." . "<br>";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 1000000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
}


?>

</body>
</html>
