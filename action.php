<?php
session_start();
include("dbconnect.php");

if(isset($_POST['registerAccountBtn'])){
	$id = mysqli_real_escape_string($connect, $_POST['id']);
	$fname = mysqli_real_escape_string($connect, $_POST['fname']);
	$lname = mysqli_real_escape_string($connect, $_POST['lname']);
	$email = mysqli_real_escape_string($connect, $_POST['email']);
	$password = mysqli_real_escape_string($connect, $_POST['password']);
	$rPassword = mysqli_real_escape_string($connect, $_POST['rPassword']);

	if($password!=$rPassword){
		$_SESSION['status'] = "Passwords do not match";
		header("Location:register.php");
	}else{
		$checkEmail = mysqli_query($connect, "SELECT * FROM user_register WHERE email = '$email'");
		if(mysqli_num_rows($checkEmail)>0){
			$_SESSION['status'] = "The email " .$email." already exists";
			header("Location:register.php");
		}else{
			$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$saveUserDataToDatabase = mysqli_query($connect, "INSERT INTO user_register(fname,lname,email,password) VALUES('$fname','$lname','$email','$hashedPassword')");

			if(!$saveUserDataToDatabase){
				$_SESSION['status'] = 'An error occuredd during registration';
				header("Location:register.php");
			}else{
				$_SESSION['loggedInUser'] = $email;
				header("Location:index.php");
			}
		}
	}
}


if(isset($_POST['loginUserBtn'])){
	$email = mysqli_real_escape_string($connect,$_POST['email']);
	$password = mysqli_real_escape_string($connect,$_POST['password']);

	$checkEmail = mysqli_query($connect, "SELECT * FROM user_register WHERE email='$email'");
	$row = mysqli_fetch_assoc($checkEmail);
	$user_pass = trim($row['password']);
	if($row['email'] === $email){
		if(password_verify($password, $user_pass)){
		    $_SESSION['loggedInUser'] = $email;			
		    header("Location:index.php");
		}else{
		    $_SESSION['status'] = 'An error occured. Try again';
		    header("Location:login.php");
		}
	}else{
		$_SESSION['status'] = 'An error occured. Try again';
		header("Location:login.php");
	}
}

if(isset($_POST['logoutBtn'])){
	session_destroy();
	unset($_SESSION['loggedInUser']);
	header("Location:login.php");
}
?>