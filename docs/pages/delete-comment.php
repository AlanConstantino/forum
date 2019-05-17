<!DOCTYPE html>
<html>
  <head>
    <?php
      session_start();
      if(!(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == TRUE)))
        exit(header('Location: ../../index.php?welcome=login'));
    ?>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <title>Login</title>
  </head>
  <header class="navbar">
    <a href="welcome.php"><h1>MEAT<span>LABS</span> Inc.</h1></a>
    <nav>
      <ul>
        <li><a href="post.php">Create Post</a></li>
        <li><a href="delete.php">Delete Post</a></li>
        <li><a href="delete-comment.php">Delete Comment</a></li>
        <li><a href="logout.php">Logout, <?php echo $_SESSION['username']; ?></a></li>
      </ul>
    </nav>
  </header>
  <body>
    <div class="all-posts">
      <h3>Click on a comment to delete it.</h3>
  	  <?php
        $connection = new mysqli('localhost', 'root', 'root', 'myDB');
        if ($connection->connect_error)
          exit(header('Location: ../../index.php?connection=fail'));

        
        if(!(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == TRUE)))
          exit(header('Location: ../../index.php?welcome=login'));


        $full_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if (strpos($full_url, 'empty'))
          echo '<p>One or more fields are empty.</p>';

        if (strpos($full_url, 'fail'))
          echo '<p id="post-fail">Failed to delete comment.</p>';

        if (strpos($full_url, 'success'))
          echo '<p id="post-success">Succesfully deleted comment.</p>';


        $sql = 'SELECT * FROM Comments WHERE user_id=' . $_SESSION['id'] . ' ORDER BY id DESC';
        $valid_query = mysqli_query($connection, $sql);

        if(mysqli_num_rows($valid_query) > 0){
          while($row = mysqli_fetch_assoc($valid_query)){
          	echo '<div class="post" id="delete-post">';
            echo '<a href="../authenticate/authenticate-delete-comment.php?comment_id=' . $row['id'] . '">';
            echo '<p>' . $row['comment'] . '</p>';
            echo '<h2>Posted by ' . $_SESSION['username'] . '<h2>';
            echo '</a>';
            echo '</div>';
          }
        }
      ?>
    </div>
  </body>
</html>