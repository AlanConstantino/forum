<?php
// start session and check if logged in
session_start();
if (!(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == TRUE)))
	exit(header('Location: ../../index.php?welcome=login'));


// get post id from url
$full_url = "https://$_SERVER[HTTP_HOST] $_SERVER[REQUEST_URI]";
$comment_id = '';
if (strpos($full_url, 'comment_id=')) {
	$url_array = explode('comment_id=', $full_url);
	$comment_id = $url_array[1];
} else {
	exit(header('Location: ../pages/delete.php?comment_id=empty'));
}


// connect to database and check connection
$connection = new mysqli('localhost', 'root', 'root', 'myDB');
if ($connection->connect_error)
	exit(header('Location: ../../index.php?connection=fail'));


// delete post from database
$sql = 'DELETE FROM Comments WHERE id="' . $comment_id . '"';
$valid_query = mysqli_query($connection, $sql);
if (!$valid_query)
	exit(header('Location: ../pages/delete-comment.php?delete=fail'));
else
	exit(header('Location: ../pages/delete-comment.php?delete=success'));


// close the connection
mysqli_close($connection);
