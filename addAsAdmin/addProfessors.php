<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <body>
    <div id="header"> Group 5</div>
    <a href="../homepage/home.php"><div id="back">Back</div></a>
    <div id="container">
      <form action="professorAdded.php" method="post">
        <h1>Professor Information</h1>
				<div class="group">
					<label for ="firstName">First Name</label><br>
					<input type="text" name="firstName" value="">
				</div>
				<div class="group">
					<label for ="middleName">Middle Name</label><br>
					<input type="text" name="middleName" value="">
				</div>
				<div class="group">
					<label for ="lastName">Last Name</label><br>
					<input type="text" name="lastName" value="">
				</div>
				<div class="group">
					<?php
						require '../connect/connect.php';
						$query = "SELECT * from department";

						$result = mysqli_query($dbc, $query) or die("addProfessors.php: Select box for department failed.");
	
						echo "<select name='department' value=''><option value='0'>Select Department:</option>";
						while($row = mysqli_fetch_assoc($result)){
							echo "<option value='{$row[departmentID]}'>{$row['departmentName']}</option>";
						}
						echo "</select>";
					?>
				</div>
			
        <br>
        <input type="submit" name="submit" value="Confirm">
      </form>
    </div>
  </body>
</html>
