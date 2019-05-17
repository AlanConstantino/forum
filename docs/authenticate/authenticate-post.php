<?php
session_start();


// check if user is logged in
if (!(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == True)))
	exit(header('Location: ../../index.php?post=login'));


// check if variables are empty
if (empty($_POST['title']) || empty($_POST['body']))
	exit(header('Location: ../pages/post.php?post=empty'));


// establish and check connection
$connection = new mysqli('localhost', 'root', 'root', 'myDB');

if ($connection->connect_error)
	exit(header('Location: ../../index.php?connection=fail'));


// save user's post to database
$title = mysqli_real_escape_string($connection, $_POST['title']);
$body = mysqli_real_escape_string($connection, $_POST['body']);
$id = mysqli_real_escape_string($connection, $_SESSION['id']);
$username = mysqli_real_escape_string($connection, $_SESSION['username']);
$sql = "INSERT INTO posts (title, body, user_id, username) 
        VALUES ('" . $title . "', '" . $body . "', 
                '" . $id . "', '" . $username . "')";
$valid_query = mysqli_query($connection, $sql);
if (!$valid_query)
	exit(header('Location: ../pages/post.php?post=fail'));
else
	exit(header('Location: ../pages/welcome.php?post=success'));


// close the connection
mysqli_close($connection);
?>