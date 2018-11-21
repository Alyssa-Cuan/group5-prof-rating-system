<!DOCTYPE html>
<html lang="en">
  <body>
<?php

if (isset($_POST['submit'])) {
    $data_missing = array();
    $out          = "";
    if (empty($_POST["courseName"])) {
        // Adds cn to array
        $data_missing[] = "Course Name ";
        
    } else {
        // Trim white space from the cn and store the cn
        $s_courseName = trim($_POST["courseName"]);
    }
    
    if (empty($_POST["courseCode"])) {
        // Adds cc to array
        $data_missing[] = "Course Code ";
        
    } else {
        // Trim white space from the cc and store the cc
        $s_courseCode = trim($_POST["courseCode"]);
    }
    
    if (empty($_POST["department"]) || $_POST["department"] == "0") {
        // Adds dept to array
        $data_missing[] = "Department ";
        
    } else {
        // Trim white space from the dept and store the dept
        $s_department = trim($_POST["department"]);
    }
    
    if (empty($_POST["school"]) || $_POST["school"] == "0") {
        // Adds school to array
        $data_missing[] = "School ";
        
    } else {
        // Trim white space from the school and store the school
        $s_school = trim($_POST["school"]);
    }
    
?>

    <div id="header"> Group 5</div>
    <div id="container">
<?php
    if (empty($data_missing)) {
        
        require '../connect/connect.php';
        
        //inserting the department
        $query = "INSERT INTO class (classID, courseCode, courseName, school, departmentID) VALUES (NULL,?,?,?,?)";
        
        $stmt = mysqli_prepare($dbc, $query);
        
        $stmt->bind_param("ssss", $s_courseCode, $s_courseName, $s_school, $s_department);
        
        $stmt->execute() or die(mysqli_error($dbc));
        
        
        //redirect to home page maybe?
        echo "<br>
      Class has been successfully added!<br>
      <a href='addClasses.php'><button type='button' name='button'>Add Another Class</button></a>
      <a href='../homepage/home.php'><button type='button' name='button'>Back to Menu</button></a>";
        
        
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach ($data_missing as $missing) {
            
            echo "$missing<br />";
            
        }
        
        
    }
    
}

?>

    </div>
  </body>
</html>