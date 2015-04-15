<?php
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();

if(!isset($_SESSION['name'])){
	$_SESSION['name'];
}
if(!isset($_SESSION['email'])){
	$_SESSION['email'];
}

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
<form method = "post" action = "<?php print($_SERVER['SCRIPT_NAME'])?>" name = "loginForm">
   Username: <input type = "text" name = "user1" /><br>
   Password: <input type = "password" name = "pass1" /><br>
<input type = "submit" name = "login" value = "Login!" />
</form>
<br><hr><br>


If you'd like to create an account login here:<br>
<form method = "post" action = "<?php print($_SERVER['SCRIPT_NAME'])?>" name = "createForm">
	Name: <input type = "text" name = "name" /><br>
   Username: <input type = "text" name = "user" /><br>
   Email: <input type = "text" name = "email" /> <br>
   Password: <input type = "password" name = "pass" /><br>
   <input type = "hidden" name = "create" value = "true" />
   <input type = "submit" name = "register" value = "Create Account!" />
   <p id = "incorrect"></p>
</form>

<?php
	if(isset($_POST["login"])){
      if(empty($_POST['user1'])){
         echo"Enter username!";
      }
     	else if(empty($_POST['pass1'])){
        echo"Enter password!";
     	}else{
     		$user = $_POST['user1'];
      	$password = $_POST['pass1'];
      	$acc = file_get_contents("accounts.json");
      	$accounts = json_decode($acc);
      	if(stripos($acc, $user) !== FALSE){
      		foreach($accounts as $key => $value){
      			if(strtolower($value->username) === strtolower($user) && $value->password === $password){
      				// echo $value->name . "<br>";
      				$_SESSION['name'] = $value->name;
      				$_SESSION['email'] = $value->email;
      				// echo $_SESSION['name'];
      				header("Location: index2.php");
      			}
               else{
                 echo "Account not found";
               }
      		}
      	}
      	else{
      		echo "Account not found";
      	}
      }
	}

	if(isset($_POST["register"])){
		$newAcc = new account();
		$newAcc->name = $_POST['name'];
		$newAcc->username = htmlentities($_POST['user']);
		$newAcc->email = htmlentities($_POST['email']);
		$newAcc->password = htmlentities($_POST['pass']);
		if(file_exists("accounts.json")){
			$acc = file_get_contents("accounts.json");
			$accounts = json_decode($acc);
		}
		if(empty($_POST['name'])){
			echo "Enter a name.";
		}
	    else if(empty($_POST['user'])){
      	echo "Enter a username.";
	   }
	   else if(empty($_POST['email'])){
	   	echo "Enter an email.";
   	}
   	else if(empty($_POST['pass'])){
      	echo "Enter a password.";
   	}
   	else if(file_exists("accounts.json") && strpos($acc, $_POST['user'])){
   		echo "Username taken.";
   	}
   	else{
			$accounts []= $newAcc;
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
