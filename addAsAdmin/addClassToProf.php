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
      <form action="classToProfAdded.php" method="post">
        <h1>Add a Class to Professor</h1>
				<div class="group">
					<?php
						require '../connect/connect.php';
						$query = "SELECT professorID, concat(firstName, ' ', lastName) AS professorName from professor";

						$result = mysqli_query($dbc, $query) or die("addClassToProf.php: Select box for prof failed.");
	
						echo "<select name='professor' value=''><option value='0'>Select Professor:</option>";
						while($row = mysqli_fetch_assoc($result)){
							echo "<option value='{$row[professorID]}'>{$row['professorName']}</option>";
						}
						echo "</select>";
					?>
				</div>
				<div class="group">
					<?php
						$query = "SELECT classID, courseName from class";

						$result = mysqli_query($dbc, $query) or die("addClassToProf.php: Select box for class failed.");
	
						echo "<select name='class' value=''><option value='0'>Select Class:</option>";
						while($row = mysqli_fetch_assoc($result)){
							echo "<option value='{$row[classID]}'>{$row['courseName']}</option>";
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
