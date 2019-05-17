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
  	<title>Create post</title>
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
      <?php 
        $full_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $post_id = '';
        if (strpos($full_url, 'post_id=')){
	        $url_array = explode('post_id=', $full_url);
	        $post_id = $url_array[1];
        }
      ?>
    <form class="box" autocomplete="off" action="../authenticate/authenticate-comment.php?post_id=<?php echo $post_id; ?>" method="POST">
      <h1>Comment</h1>
      <textarea name="body" rows="5" cols="50" maxlength="500" placeholder="Text goes here"></textarea>
      <button type="submit">Comment</button>
      <div class="errors">
        <?php          
          $full_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

          if (strpos($full_url, 'comment=fail'))
            echo '<p>Failed to create comment, try again.</p>';

          if (strpos($full_url, 'comment=empty'))
            echo '<p>You left the comment blank.</p>';

          if (strpos($full_url, 'post_id=empty'))
            echo '<p>Post ID is not valid.</p>';
        ?>
      </div>
    </form>
  </body>
</html>