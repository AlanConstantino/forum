<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Login</title>
</head>

<body>
  <form class="box" autocomplete="off" action="docs/authenticate/authenticate-login.php" method="POST" id="login">
    <h1>Login</h1>
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button type="submit" id="login">Login</button>
    <button type="submit" formaction="docs/pages/signup.php" id="signup">Signup</button>
    <div class="errors">
      <?php
      // $deployToHeroku = true;

      // if ($deployToHeroku) {
      //   $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
      //   $host        = $cleardb_url["host"];
      //   $user        = $cleardb_url["user"];
      //   $password    = $cleardb_url["pass"];
      //   $database    = substr($cleardb_url["path"], 1);
      // } else {
      //   $host        = 'localhost';
      //   $user        = 'root';
      //   $password    = 'root';
      //   $database    = 'myDB';
      // }

      $connection = new mysqli($host, $user, $password, $database);

      session_start();
      $full_url = "https://$_SERVER[HTTP_HOST] $_SERVER[REQUEST_URI]";

      if (strpos($full_url, 'empty'))
        exit('<p>One or more fields are empty.</p>');

      if (strpos($full_url, 'email-password'))
        exit('<p>Email and/or password didn\'t match, try again.</p>');

      if (strpos($full_url, 'fail'))
        exit('<p>Connection to the server has failed.</p>');

      if (strpos($full_url, 'query'))
        exit('<p>Query to the database has failed.</p>');

      if (strpos($full_url, 'login'))
        exit('<p>You are not signed in.</p>');
      ?>
    </div>
  </form>
</body>

</html>