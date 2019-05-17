<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <title>Sign Up</title>
  </head>
  <body>
  	<form class="box" autocomplete="off" action="../authenticate/authenticate-signup.php" method="POST">
      <h1>Signup</h1>
      <input type="text" name="firstname" placeholder="First name">
      <input type="text" name="lastname" placeholder="Last name">
      <input type="text" name="username" placeholder="Username">
      <input type="email" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
  		<button type="submit">Register</button>
      <div class="errors">
        <?php
          $full_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
              
          if (strpos($full_url, 'empty'))
            exit('<p>One or more fields are empty.</p>');

          if (strpos($full_url, 'email'))
            exit('<p>Email is already in use, try again.</p>');

          if (strpos($full_url, 'username'))
            exit('<p>Username is already in use, try again.</p>');

          if (strpos($full_url, 'insert'))
            exit('<p>Could not add user to database, try again later.</p>');
        ?>
      </div>
  	</form>
  </body>
</html>