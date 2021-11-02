<?php

$server = "localhost";
$user = "root";
$pass = "";
$dbname = "exercise";
$nameErr = False;
 
//Creating connection for mysqli
 
$conn = new mysqli($server, $user, $pass, $dbname);
 
//Checking connection
 
if($conn->connect_error){
 die("Connection failed:" . $conn->connect_error);
}

$name = mysqli_real_escape_string($conn, $_POST['name']);
$surname = mysqli_real_escape_string($conn, $_POST['surname']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);


$sql = "INSERT INTO contact (FirstName, LastName, Address, Email,Phone) VALUES ('$name', '$surname', '$address','$email','$phone')";
 
 
if($conn->query($sql) === TRUE){
 echo "Record Added Sucessfully";
}
else
{
 echo "Error" . $sql . "<br/>" . $conn->error;
}
$conn->close();


?>