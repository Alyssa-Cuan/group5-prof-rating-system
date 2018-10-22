<?php
require 'searchProfessors.html'; //using the html framework

//search function for professors
function search()
{
    
    //initialization of variables
    require '../connect/connect.php';
    $classID  = "";
    $allBlank = true;
    
    //get post from previous form
    @$firstName = $_POST['firstName'];
	@$middleName = $_POST['middleName'];
    @$lastName = $_POST['lastName'];
    @$class = $_POST['class'];
    @$department = $_POST['department'];
    
    //build the initial query
    $query      = "CREATE OR REPLACE VIEW profSearch AS SELECT profclass.professorID, courseCode, class.classID FROM professor, profclass, class";
    $conditions = array();
    
    //check if search by class is not empty
    if (!empty($class)) {
        //gets classID from course code
        $q = "SELECT classID FROM class WHERE courseCode='$class' LIMIT 1";
        $result = mysqli_query($dbc, $q) or trigger_error(mysqli_error($dbc));
        $row1    = mysqli_fetch_array($result);
        $classID = $row1['classID'];
        $allBlank = false;
    }
    
    //check if variables are not empty, if not empty
    //add them to condition for the WHERE clause
    if (!empty($firstName)) {
        $conditions[] = "professor.firstName='$firstName'";
        $allBlank     = false;
    }
	if (!empty($middleName)) {
        $conditions[] = "professor.middleName='$middleName'";
        $allBlank     = false;
    }
    if (!empty($lastName)) {
        $conditions[] = "professor.lastName='$lastName'";
        $allBlank     = false;
    }
    if (!empty($department)) {
        //gets departmentID from department name
        $q = "SELECT departmentID FROM department WHERE departmentName = '$department' LIMIT 1";
        $result = mysqli_query($dbc, $q) or trigger_error(mysqli_error($dbc));
        $row0   = mysqli_fetch_array($result);
        $deptID = $row0['departmentID'];
        
        //before adding deptID to conditions
        $conditions[] = "professor.departmentID=$deptID";
        $allBlank     = false;
    }
    
    //build the initial query with WHERE clause
    $sql = $query;
    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    
    //append the join and classID conditions at the end
    if (!empty($class)) {
        if (!empty($firstName) || !empty($lastName) || !empty($department) || !empty($middleName))
            $sql .= " AND ";
        else
            $sql .= " WHERE ";
        $sql .= "professor.professorID = profclass.professorID AND profclass.classID=$classID AND profclass.classID = class.classID";
    }else{
		$sql .= "AND profclass.professorID = professor.professorID AND profclass.classID = class.classID";
	}
    
    //print table
    //printing table headings (ordered asc)
    echo "<table name='profData' border='1'>";
    echo "<tr><td>Professor Name</td><td>Course</td>";
    $tableHeadings = array(
        "GRADING",
        "LENIENCY",
        "STRICTNESS"
    );
    $arrlength = count($tableHeadings);
    
    for ($x = 0; $x < $arrlength; $x++) {
        echo "<td>" . $tableHeadings[$x] . "</td>";
    }
    echo "<td>View</td></tr>";
    
    //exit if all fields are blank/null
    if ($allBlank) {
        exit(0);
    }
    
    //echo $sql; //check the sql query code
    
    //CREATE VIEW
    $result = mysqli_query($dbc, $sql) or trigger_error(mysqli_error($dbc));
    
    //Get the profID and profName of the ones in the VIEW by joining them
    $sql = "SELECT profSearch.professorID, CONCAT(firstName, ' ', middleName, ' ', lastName) AS profName, profSearch.courseCode, profSearch.classID FROM professor, profSearch WHERE professor.professorID = profSearch.professorID";
    $result = mysqli_query($dbc, $sql) or trigger_error(mysqli_error($dbc));
    
    
    //printing each row with profName, ratingValue1, 2, 3...
    while ($row = mysqli_fetch_assoc($result)) {
        
        //query building for each professor
        $professorID = $row['professorID'];
		$cID = $row['classID'];
        $ratingSql   = "SELECT ratingName, professorID, ROUND(AVG(ratingValue),2) AS aveRating FROM rating WHERE professorID=$professorID ";
        if (!empty($class)) {
            $ratingSql .= "AND classID=$classID ";
        }else{
			$ratingSql .= "AND classID=$cID ";
		}
        $ratingSql .= "GROUP BY professorID, ratingName ORDER BY ratingName ASC";
        $res = mysqli_query($dbc, $ratingSql) or trigger_error(mysqli_error($dbc));
        
        //printing the row
        echo "<tr><td>{$row['profName']}</td><td>{$row['courseCode']}</td>";
        
        while ($row2 = mysqli_fetch_assoc($res)) {
            echo "<td>{$row2['aveRating']}</td>";
        }
        
        //if no ratings yet, populate with NONE value
        if (mysqli_num_rows($res) == 0) {
            for ($x = 0; $x < $arrlength; $x++) {
                echo "<td>" . "None" . "</td>";
            }
            
        }
        
        //link to view prof's profile
        echo "<td><a href=../view/profDataView.php?ID={$row['professorID']}&CID={$row['classID']}>View</a></td></tr>";
    }
    echo "</table>";
}

//execute search
try {
    search();
}
catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}
?>