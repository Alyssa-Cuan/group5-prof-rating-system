<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <body>
    <div id="header"> Group 5</div>
    <a href="../homepage/home.php"><div id="back">Back</div></a>
    <div id="container">
      <form action="departmentAdded.php" method="post">
        <h1>Department Information</h1>
				<div class="group">
					<label for ="firstname">Department Name</label><br>
					<input type="text" name="departmentName" value="">
				</div>
        <br>
        <input type="submit" name="submit" value="Confirm">
      </form>
    </div>
  </body>
</html>
