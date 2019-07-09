<?php
session_start();


// make sure login data isn't empty
if (empty($_POST['email']) || empty($_POST['password']))
	exit(header('Location: ../../index.php?index=empty'));


// establish and check connection
$connection = new mysqli('localhost', 'root', 'root', 'myDB');

if ($connection->connect_error)
	exit(header('Location: ../../index.php?connection=fail'));


// query database
$sql = "SELECT * FROM Users WHERE email='" . $_POST['email'] . "'";
$valid_query = mysqli_query($connection, $sql);

if (!$valid_query)
	exit(header('Location: ../../index.php?login=query'));


// verify password against database
$row = mysqli_fetch_array($valid_query);
$hashed_password = $row['password'];
$sql = "SELECT * FROM Users WHERE email='" . $_POST['email'] . "'";

if (password_verify($_POST['password'], $hashed_password)) {
	$username_query = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($username_query);
	$_SESSION['id'] = $row['id'];
	$_SESSION['username'] = $row['username'];
	$_SESSION['firstname'] = $row['firstname'];
	$_SESSION['lastname'] = $row['lastname'];
	$_SESSION['email'] = $row['email'];
	$_SESSION['loggedin'] = TRUE;
	exit(header('Location: ../pages/welcome.php'));
} else {
	exit(header('Location: ../../index.php?index=email-password'));
}


// close the connection
mysqli_close($connection);
