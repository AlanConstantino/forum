<!DOCTYPE html>
<html>

<head>
  <?php
  session_start();
  if (!(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == TRUE)))
    exit(header('Location: ../../index.php?welcome=login'));
  ?>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../../style.css">
  <title>Home</title>
</head>
<header class="navbar">
  <a href="welcome.php">
    <h1>MEAT<span>LABS</span> Inc.</h1>
  </a>
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
    <h3>Click on a post to comment on it.</h3>
    <?php
    $host = 'us-cdbr-iron-east-02.cleardb.net';
    $user = 'b6bfe072008d57';
    $password = '6bb6ea55';
    $database = 'heroku_13fe3b2a9c7de33';

    // $deployToHeroku = true;

    // if ($deployToHeroku) {
    // $cleardb_url      = parse_url(getenv("CLEARDB_DATABASE_URL"));
    // $cleardb_server   = $cleardb_url["host"];
    // $cleardb_username = $cleardb_url["user"];
    // $cleardb_password = $cleardb_url["pass"];
    // $cleardb_db       = substr($cleardb_url["path"], 1);

    // echo '<p>' + $cleardb_server + '<br></p>';
    // echo '<p>' + $cleardb_username + '<br></p>';
    // echo '<p>' + $cleardb_password + '<br></p>';
    // echo '<p>' + $cleardb_db + '<br></p>';

    // $active_group = 'default';
    // $query_builder = TRUE;

    // $db['default'] = array(
    //   'dsn'    => '',
    //   'hostname' => $cleardb_server,
    //   'username' => $cleardb_username,
    //   'password' => $cleardb_password,
    //   'database' => $cleardb_db,
    //   'dbdriver' => 'mysqli',
    //   'dbprefix' => '',
    //   'pconnect' => FALSE,
    //   'db_debug' => (ENVIRONMENT !== 'production'),
    //   'cache_on' => FALSE,
    //   'cachedir' => '',
    //   'char_set' => 'utf8',
    //   'dbcollat' => 'utf8_general_ci',
    //   'swap_pre' => '',
    //   'encrypt' => FALSE,
    //   'compress' => FALSE,
    //   'stricton' => FALSE,
    //   'failover' => array(),
    //   'save_queries' => TRUE
    // );
    // } else {
    //   $host        = 'localhost';
    //   $user        = 'root';
    //   $password    = 'root';
    //   $database    = 'myDB';
    // }

    $connection = new mysqli($host, $user, $password, $database);

    // $connection = new mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

    if ($connection->connect_error)
      exit(header('Location: ../../index.php?connection=fail'));

    $full_url = "https://$_SERVER[HTTP_HOST] $_SERVER[REQUEST_URI]";

    if (strpos($full_url, 'post=success'))
      echo '<p id="post-success">Succesfully created post.</p>';

    if (strpos($full_url, 'post=fail'))
      echo '<p id="post-fail">Failed trying to create post.</p>';

    if (strpos($full_url, 'comment=success'))
      echo '<p id="post-success">Succesfully created comment.</p>';

    if (strpos($full_url, 'comment=fail'))
      echo '<p id="post-fail">Failed trying to create post.</p>';

    $sql = "SELECT * FROM Posts ORDER BY id DESC";
    $valid_query = mysqli_query($connection, $sql);
    $post_id = '';

    if (mysqli_num_rows($valid_query) > 0) {
      while ($row = mysqli_fetch_assoc($valid_query)) {
        echo '<div class="post" id="select-post">';
        echo '<a href="comment.php?post_id=' . $row['id'] . '">';
        $post_id = $row['id'];
        echo '<h1>' . $row['title']    . '</h1>';
        echo '<p>' . $row['body'] . '</p>';
        echo '<h2>Posted by ' . $row['username'] . '<h2>';

        $sql_comment = "SELECT * FROM Comments WHERE post_id='" . $post_id . "' ORDER BY id DESC";
        $valid_query_comment = mysqli_query($connection, $sql_comment);


        if (mysqli_num_rows($valid_query_comment) > 0) {
          while ($row_comment = mysqli_fetch_assoc($valid_query_comment)) {
            if ($row_comment['post_id'] == $post_id) {
              echo '<div class"post" id="comment">';
              echo '<p>' . $row_comment['comment'] . '</p>';

              $sql_statement = "SELECT username FROM Users WHERE id='" . $row_comment['user_id'] . "'";
              $query = mysqli_query($connection, $sql_statement);
              $username = '';
              if ($query) {
                while ($row_query = mysqli_fetch_assoc($query)) {
                  $username = $row_query['username'];
                }
              }
              echo '<h2>Comment by ' . $username . '</h2>';
              echo '</div>';
            }
          }
        }
        echo '</a>';
        echo '</div>';
      }
    }
    ?>
  </div>
</body>

</html>