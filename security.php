<?php 
session_start();
if(!isset($_SESSION['loggedInUser'])){
	header('Location:login.php?reason=Login first');
	$_SESSION['status'] = 'Login first';
}
?>