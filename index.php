<?php
session_start();
$logins = array('admin' => 'abc');
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
if (isset($logins[$username]) && $logins[$username] == $password) {
  header("location: homepage/homeAdmin.php");
  exit;
}
else {
  $msg="<span style='color:red;'>Invalid Login Details</span>";
}
?>

<html>
  <body>
    <div id="container">
      <h1>Group 5</h1>
      <form action="" method="post" autocomplete="off">
        <div id = "credentials">
          <div class="labels"></div><input type="text" name="username" placeholder="Username"><br>
          <div class="labels"></div><input type="password" name="password" placeholder="Password">
        </div>
        <input type="submit" name="submit" value="Log In">
        <?php if(isset($msg) && isset($_POST['submit'])) {?>
        <div class="error"><?php echo $msg;?></div>
         <?php } ?>
      </form>
    </div>

  </body>
</html>
