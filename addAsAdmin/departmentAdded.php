<!DOCTYPE html>
<html lang="en">
  <body>
    <?php

if(isset($_POST['submit'])){
    $data_missing = array();
	   $out = "";
	if(empty($_POST["departmentName"])){
        // Adds name to array
        $data_missing[] = "Department Name ";

    } else {
        // Trim white space from the name and store the name
        $s_departmentName = trim($_POST["departmentName"]);
    }

    ?>

    <div id="header"> Group 5</div>
    <div id="container">
      <?php
      if(empty($data_missing)){

        require '../connect/connect.php';

		//inserting the department
        $query = "INSERT INTO department (departmentID, departmentName) VALUES (NULL,?)";

		$stmt = mysqli_prepare($dbc, $query);

		$stmt->bind_param("s", $s_departmentName);

		$stmt->execute() or die(mysqli_error($dbc));


		//redirect to home page maybe?
		echo "<br>
      Department has been successfully added!<br>
      <a href='addDepartments.php'><button type='button' name='button'>Add Another Department</button></a>
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
