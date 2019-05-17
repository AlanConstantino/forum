<?php
session_start();


// make sure signup data is not empty
if (empty($_POST['firstname'])
   || empty($_POST['lastname']) 
   || empty($_POST['username']) 
   || empty($_POST['email']) 
   || empty($_POST['password'])
){
   	exit(header('Location: ../pages/signup.php?signup=empty'));
}


// signup data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);


// establish and check connection
$connection = new mysqli('localhost', 'root', 'root', 'myDB');

if ($connection->connect_error)
	exit(header('Location: ../../index.php?connection=fail'));


// query username from database
$sql = "SELECT * FROM Users WHERE username='$username'";
$valid_usersname = mysqli_query($connection, $sql);

if (mysqli_num_rows($valid_username) > 0)
	exit(header('Location: ../pages/signup.php?signup=username'));


// query email from database
$sql = "SELECT * FROM Users WHERE email='$email'";
$valid_email = mysqli_query($connection, $sql);

if(mysqli_num_rows($valid_email) > 0)
	exit(header('Location: ../pages/signup.php?signup=email'));


// add user to database
$sql = "INSERT INTO Users (firstname, lastname, email, 
                           username, password) 
        VALUES            ('$firstname', '$lastname', '$email', 
                           '$username', '$password')";
$insert = mysqli_query($connection, $sql);

if($insert === TRUE){
	$sql = "SELECT * FROM Users WHERE email='$email'";
	$info_query = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($info_query);
	$_SESSION['id'] = $row['id'];
	$_SESSION['username'] = $row['username'];
	$_SESSION['firstname'] = $row['firstname'];
	$_SESSION['lastname'] = $row['lastname'];
	$_SESSION['email'] = $row['email'];
	$_SESSION['loggedin'] = TRUE;
	exit(header('Location: ../pages/welcome.php'));
} else{
	exit(header('Location: ../pages/signup.php?signup=insert'));
}


// close the connection
mysqli_close($connection);
?>