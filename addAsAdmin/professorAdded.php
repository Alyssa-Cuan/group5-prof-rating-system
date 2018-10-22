<!DOCTYPE html>
<html lang="en">
  <body>
    <?php

		if(isset($_POST['submit'])){
			$data_missing = array();
			$out = "";
			if(empty($_POST["firstName"])){
				// Adds fn to array
				$data_missing[] = "First Name ";

			} else {
				// Trim white space from the fn and store the fn
				$s_firstName = trim($_POST["firstName"]);
			}
			
			if(empty($_POST["middleName"])){
				// Adds mn to array
				$data_missing[] = "Middle Name ";

			} else {
				// Trim white space from the mn and store the mn
				$s_middleName = trim($_POST["middleName"]);
			}
			
			if(empty($_POST["lastName"])){
				// Adds ln to array
				$data_missing[] = "Last Name ";

			} else {
				// Trim white space from the ln and store the ln
				$s_lastName = trim($_POST["lastName"]);
			}
			
			if(empty($_POST["department"]) || $_POST["department"] == "0"){
				// Adds dept to array
				$data_missing[] = "Department ";

			} else {
				// Trim white space from the dept and store the dept
				$s_department = trim($_POST["department"]);
			}
		
    ?>

    <div id="header"> Group 5</div>
    <div id="container">
      <?php
      if(empty($data_missing)){

        require '../connect/connect.php';

		//inserting the professor
        $query = "INSERT INTO professor (professorID, firstName, middleName, lastName, departmentID) VALUES (NULL,?,?,?,?)";

		$stmt = mysqli_prepare($dbc, $query);

		$stmt->bind_param("ssss", $s_firstName, $s_middleName, $s_lastName, $s_department);

		$stmt->execute() or die(mysqli_error($dbc));


		//redirect to home page maybe?
		echo "<br>
      Class has been successfully added!<br>
      <a href='addProfessors.php'><button type='button' name='button'>Add Another Professor</button></a>
      <a href='../homepage/homeAdmin.php'><button type='button' name='button'>Back to Menu</button></a>";


    } else {

        echo 'You need to enter the following data<br />';

        foreach($data_missing as $missing){

            echo "$missing<br />";

        }


    }
	
}

?>
    </div>
  </body>
</html>
