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
    <form class="box" autocomplete="off" action="../authenticate/authenticate-post.php" method="POST">
      <h1>Create Post</h1>
      <input id="post-title" autocomplete="off" type="text" name="title" maxlength="100" placeholder="Title">
      <textarea name="body" rows="5" cols="50" maxlength="500" placeholder="Text goes here"></textarea>
      <button type="submit">Post</button>
      <div class="errors">
        <?php          
          $full_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

          if (strpos($full_url, 'post=fail'))
            echo '<p>Failed to create post, try again.</p>';

          if (strpos($full_url, 'empty'))
            echo '<p>One or more fields are empty.</p>';
        ?>
      </div>
    </form>
  </body>
</html>