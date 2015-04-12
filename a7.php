<?php
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();
class account{

}
$accounts = array();
?>
<html>
<body>
<head><title>Thy's Bad DropBox!</title></head>
<h1>Thy's Bad DropBox</h1>
<br>

If you have an existing account login here:<br>
<form method = "post" action = "index.php" name = "loginForm">
   Username: <input type = "text" name = "user1" /><br>
   Password: <input type = "password" name = "pass1" /><br>
<input type = "submit" name = "login" value = "Login!" />
</form>
<br><hr><br>


If you'd like to create an account login here:<br>
<form method = "post" action = "index.php" name = "createForm">
   Username: <input type = "text" name = "user" /><br>
   Email: <input type = "text" name = "email" /> <br>
   Password: <input type = "password" name = "pass" /><br>
   <input type = "hidden" name = "create" value = "true" />
   <input type = "submit" name = "register" value = "Create Account!" />
   <p id = "incorrect"></p>
</form>

<?php
	if(isset($_POST["register"])){
	   $newAcc->username = htmlentities($_POST['user']);
		$newAcc->email = htmlentities($_POST['email']);
		$newAcc->password = htmlentities($_POST['pass']);
		$accounts []= $newAcc;
	   if(empty($_POST['user'])){
      	echo "Enter a username.";
	   }
	   else if(empty($_POST['email'])){
	   	echo "Enter an email.";
	   }
	   else if(empty($_POST['pass'])){
	      echo "Enter a password.";
	   }
	   else{
	   	$fh = fopen("accounts.json", 'w');
        	if($fh === false)
            die("Failed to open accounts.json for writing.");
        	else{
            fwrite($fh, json_encode($accounts));
            fclose($fh);
        	}
	   }
	}
?>

</body>
</html>
