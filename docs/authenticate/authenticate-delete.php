<?php
// start session and check if logged in
session_start();
if (!(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == TRUE)))
	exit(header('Location: ../../index.php?welcome=login'));


// get post id from url
$full_url = "https://$_SERVER[HTTP_HOST] $_SERVER[REQUEST_URI]";
$post_id = '';
if (strpos($full_url, 'post_id=')) {
	$url_array = explode('post_id=', $full_url);
	$post_id = $url_array[1];
} else {
	exit(header('Location: ../pages/delete.php?post_id=empty'));
}


// connect to database and check connection
$connection = new mysqli('localhost', 'root', 'root', 'myDB');
if ($connection->connect_error)
	exit(header('Location: ../../index.php?connection=fail'));


// delete post from database
$sql = 'DELETE FROM Posts WHERE id="' . $post_id . '"';
$valid_query = mysqli_query($connection, $sql);
if (!$valid_query)
	exit(header('Location: ../pages/delete.php?delete=fail'));
else
	exit(header('Location: ../pages/delete.php?delete=success'));


// close the connection
mysqli_close($connection);
