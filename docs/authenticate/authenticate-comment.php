<?php
// start session and check if logged in
session_start();
if (!(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == TRUE)))
	exit(header('Location: ../../index.php?welcome=login'));


// check if comment is empty
if (empty($_POST['body']))
	exit(header('Location: ../pages/comment.php?comment=empty'));


// establish and check connection
$connection = new mysqli('localhost', 'root', 'root', 'myDB');

if ($connection->connect_error)
	exit(header('Location: ../../index.php?connection=fail'));


// get post id
$full_url = "https://$_SERVER[HTTP_HOST] $_SERVER[REQUEST_URI]";
$post_id = '';
if (strpos($full_url, 'post_id=')) {
	$url_array = explode('post_id=', $full_url);
	$post_id = $url_array[1];
} else {
	exit(header('Location: ../pages/comment.php?post_id=empty'));
}


// save user's comment
$comment = mysqli_real_escape_string($connection, $_POST['body']);
$sql = "INSERT INTO Comments (user_id, post_id, comment)
        VALUES ('" . $_SESSION['id'] . "', '" . $post_id . "', '" . $comment . "')";
$insert = mysqli_query($connection, $sql);

if ($insert === TRUE)
	exit(header('Location: ../pages/welcome.php?comment=success'));
else
	exit(header('Location: ../pages/welcome.php?comment=fail'));


// close the connection
mysqli_close($connection);
