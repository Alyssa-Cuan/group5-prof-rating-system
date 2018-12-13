<?php
require '../homepage/homeTemplate.php'
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.18/r-2.2.2/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.18/r-2.2.2/datatables.min.js"></script><script type="text/javascript">
    $(document).ready( function () {
            //put the id of table here
            $('#myTable').DataTable({
                responsive:true
            });
        }
    ); </script>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/dataTables.responsive.css">

</script>
	  <?php

//search function for professors
function search()
{
    //initialization of variables
    @require '../connect/connect.php';
	require '../modules/modules.php';
	
    $opcode = "";
	$ID = "";
	$query = "";
    $arrlength = count($tableHeadings);
    
    //get post from previous form
	if(isset($_POST['selectedID'])){
		@$selectedID = $_POST['selectedID'];
	}
	
	if(isset($_GET['selectedID'])){
		@$selectedID = $_GET['selectedID'];
	}

	
	if (!empty($selectedID)) {
		$opcode = substr($selectedID,0,1);
		$ID = substr($selectedID,1);

        //print table
        //printing table headings (ordered asc)
        echo "<div class='container show'>";
        echo "<table name='profData' id='professors' align='center' class='table table-striped table-bordered'> ";
        echo "<thead><tr><th>Professor Name</th><th>Course</th>";



        for ($x = 0; $x < $arrlength; $x++) {
            echo "<th>" . $tableHeadings[$x] . "</th>";
        }
        echo "<th>View</th></tr></thead>";
    }else{
		exit(0);
	}
    
	
    //build the initial query
	if($opcode == "p"){
		$query = "SELECT profclass.professorID, profclass.classID, CONCAT(courseCode, ' - ', courseName) AS course, CONCAT(lastName, ', ', firstName, ' ', middleName) AS profName FROM profclass, professor, class WHERE profclass.professorID='$ID' AND professor.professorID = profclass.professorID AND class.classID = profclass.classID";
	}else if($opcode == "c"){
		$query = "SELECT profclass.professorID, profclass.classID, CONCAT(courseCode, ' - ', courseName) AS course, CONCAT(lastName, ', ', firstName, ' ', middleName) AS profName FROM profclass, professor, class WHERE profclass.classID='$ID' AND professor.professorID = profclass.professorID AND class.classID = profclass.classID";
	}else if($opcode == "d"){
		$query = "SELECT profclass.professorID, profclass.classID, CONCAT(courseCode, ' - ', courseName) AS course, CONCAT(lastName, ', ', firstName, ' ', middleName) AS profName FROM profclass, professor, department, class WHERE department.departmentID='$ID' AND professor.departmentID = department.departmentID AND professor.professorID = profclass.professorID AND profclass.classID = class.classID";
	}else{
		exit(0);
	}
    
    $result = mysqli_query($dbc, $query) or trigger_error(mysqli_error($dbc));
    echo "<tbody>";
    //printing each row with profName, ratingValue1, 2, 3...
    while ($row = mysqli_fetch_assoc($result)) {
        
        //query building for each professor
        $professorID = $row['professorID'];
		$classID = $row['classID'];
        $ratingSql   = "SELECT ratingName, professorID, ROUND(AVG(ratingValue),2) AS aveRating FROM rating WHERE professorID=$professorID AND classID=$classID ";
        $ratingSql .= "GROUP BY professorID, ratingName ORDER BY ratingName ASC";
        $res = mysqli_query($dbc, $ratingSql) or trigger_error(mysqli_error($dbc));
        
        //printing the row
        echo "<tr><td>{$row['profName']}</td><td>{$row['course']}</td>";
        
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
	echo "</tbody>";
    echo "</table>";
	echo "</div>";
	
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
	  


    <!-- /.container -->

    <!--
      JavaScript
      ==================================================
    -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	
	<script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>>
	<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/popper.js/dist/popper.min.js"></script>
    <script type="text/javascript" charset="utf8" src="../node_modules/datatables.net/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#professors').DataTable( {
        "searching":   false
    } );
        });
    </script>
	
  </body>
</html>
