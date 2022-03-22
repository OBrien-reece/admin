<?php
$connect = mysqli_connect('localhost','root','','alcatraz');

if(!$connect){
echo "<h3 class='alert alert-danger'>Could not establish connection with the database</h3>";
}
?>