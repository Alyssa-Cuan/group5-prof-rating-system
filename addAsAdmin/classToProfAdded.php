<!DOCTYPE html>
<html lang="en">
  <body>
    <?php

		if(isset($_POST['submit'])){
			$data_missing = array();
			$out = "";

			if(empty($_POST["professor"]) || $_POST["professor"] == "0"){
				// Adds name to array
				$data_missing[] = "Professor ";

			} else {
				// Trim white space from the name and store the name
				$s_professor = trim($_POST["professor"]);
			}
			if(empty($_POST["class"]) || $_POST["class"] == "0"){
				// Adds name to array
				$data_missing[] = "Class ";

			} else {
				// Trim white space from the name and store the name
				$s_class = trim($_POST["class"]);
			}
		
    ?>

    <div id="header"> Group 5</div>
    <div id="container">
      <?php
      if(empty($data_missing)){

        require '../connect/connect.php';

		//inserting the department
        $query = "INSERT INTO profclass (professorID, classID) VALUES (?,?)";

		$stmt = mysqli_prepare($dbc, $query);

		$stmt->bind_param("ii", $s_professor, $s_class);

		
		$stmt->execute() or die(mysqli_error($dbc));


		//redirect to home page maybe?
		echo "<br>
      Class has been successfully added to Professor!<br>
      <a href='addClassToProf.php'><button type='button' name='button'>Add Another Class to Professor</button></a>
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
