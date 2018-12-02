<?php
require '../homepage/homeTemplate.php'
?>
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
        echo "<div class='container'>";
        echo "<table name='profData' id='professors' align='center' class='table table-striped table-bordered'> ";
        echo "<thead><tr><th onclick='sortTable(0)'>Professor Name</th><th onclick='sortTable(1)'>Course</th>";



        for ($x = 0; $x < $arrlength; $x++) {
            echo "<th onclick='sortTable(" . (2+$x) . ")'>" . $tableHeadings[$x] . "</th>";
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

<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("professors");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  type = "string";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
	  
	  if(!isNaN(Number(x.innerHTML))){
		  type = "number";
	  }

      if (dir == "asc") {
        if (type == "string" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
		
		if(type == "number"){
			if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
				shouldSwitch = true;
				break;
			}
		}
      } else if (dir == "desc") {
        if (type == "string" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
		
		if(type == "number"){
			if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
				shouldSwitch = true;
				break;
			}
		}
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
	  


    <!-- /.container -->

    <!--
      JavaScript
      ==================================================
    -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
