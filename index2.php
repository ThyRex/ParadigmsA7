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
<form name  = "logoutForm" action = "index.php" method = "post">
   <input type = "submit" name = "exit" value = "Logout" />
</form>

<form method="post" action = "<?php print($_SERVER['SCRIPT_NAME'])?>" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
</form>

<?php
if(!is_dir("Users")){
	mkdir("Users");
}

$target_dir = "Users/" . $_SESSION['name']. "/";
$oldmask = umask(0);
if(!is_dir($target_dir)){
	if(!mkdir($target_dir)){
		die("Error: Failed to make folder.");
	}
}
umask($oldmask);

if(isset($_POST["submit"])){
	if($_FILES['fileToUpload']['size'] === 0){
		echo "No file selected for upload.";
	}
	else{
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
	
		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists. <br>";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 1000000) {
		    echo "Sorry, your file is too large. <br>";
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded. <br>";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded." . "<br>";
		    } else {
		        echo "Sorry, there was an error uploading your file. <br>";
		    }
		}
	}
}
// print_r($tableOfFiles);

?>

<form name  = "delete" action = "<?php print($_SERVER['SCRIPT_NAME'])?>" method = "post">
<?php
if(is_dir($target_dir)){
	$tableOfFiles = scandir($target_dir);

	foreach($tableOfFiles as $fileT) {
	    if ($fileT != "." && $fileT != "..") {
	    	$fileT = str_replace(' ', '%20', $fileT);
	    	echo "<input type=\"checkbox\" name=\"check_list[]\" value=\"" . $fileT . "\">";
	    	echo "<a href=". "Users/" . $_SESSION['name'] ."/" . $fileT ." download>" . $fileT . "</a><br>";
	    }
	}
}
?>
   <input type = "submit" name = "delete" value = "Delete" />
</form>

<?php

if(isset($_POST['delete'])){
	// print_r($_POST['check_list']);
	if(!empty($_POST['check_list'])) {
		// Loop to store and display values of individual checked checkbox.
		foreach($_POST['check_list'] as $selected) {
			// echo "<p>".$selected ."</p>";
			unlink($target_dir . $selected);
			unset($tableOfFiles[$selected]);
		}
	}
	else{
		echo "<b>Please Select Atleast One Option.</b>";
	}
	header("Location: index2.php");
}
?>

</body>
</html>
