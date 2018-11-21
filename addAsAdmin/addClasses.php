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
      <form action="classAdded.php" method="post">
        <h1>Class Information</h1>
				<div class="group">
					<label for ="courseName">Course Name</label><br>
					<input type="text" name="courseName" value="">
				</div>
				<div class="group">
					<label for ="courseCode">Course Code</label><br>
					<input type="text" name="courseCode" value="">
				</div>
				<div class="group">
					<?php
						require '../connect/connect.php';
						$query = "SELECT * from department";

						$result = mysqli_query($dbc, $query) or die("addClasses.php: Select box for department failed.");
	
						echo "<select name='department' value=''><option value='0'>Select Department:</option>";
						while($row = mysqli_fetch_assoc($result)){
							echo "<option value='{$row[departmentID]}'>{$row['departmentName']}</option>";
						}
						echo "</select>";
					?>
				</div>
				<div class="group">
					<select name="school" value=''>
					<option value="0">Select School:</option> 
					<option value="SOM">SOM</option> 
					<option value="SOSE">SOSE</option> 
					<option value="SOH">SOH</option> 
					<option value="SOSS">SOSS</option> 
					</select>
				</div>
			
        <br>
        <input type="submit" name="submit" value="Confirm">
      </form>
    </div>
  </body>
</html>
