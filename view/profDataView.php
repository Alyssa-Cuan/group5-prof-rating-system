<?php
if(isset($_GET['ID']) && isset($_GET['CID'])){
	require_once '../connect/connect.php';
	$ID = mysqli_real_escape_string($dbc, $_GET['ID']);
	$CID = mysqli_real_escape_string($dbc, $_GET['CID']);
	
	//get the prof name and home dept
	$query = "SELECT CONCAT(firstName, ' ', middleName, ' ', lastName) AS profName, departmentName FROM professor, department WHERE professorID = '$ID' AND department.departmentID = professor.departmentID LIMIT 1";
	$nameDeptResult = mysqli_query($dbc, $query) or die("ERROR S");
	$nameDept = mysqli_fetch_array($nameDeptResult);
	
	//get the current class of the profName
	$query = "SELECT courseCode FROM class WHERE classID = '$CID' LIMIT 1";
	$currCourseResult = mysqli_query($dbc, $query) or die("ERROR S");
	$currCourse = mysqli_fetch_array($currCourseResult);
	
	//get the ratings
	$query = "SELECT ratingName, professorID, ROUND(AVG(ratingValue),2) AS aveRating FROM rating WHERE professorID='$ID' AND classID='$CID' GROUP BY ratingName, professorID ORDER BY ratingName ASC";
	$ratingResult = mysqli_query($dbc, $query) or die("ERROR S");
	
	//get the courses taught
	$query = "SELECT courseCode FROM profclass, class WHERE profclass.professorID='$ID' AND profclass.classID = class.classID";
	$courseResult = mysqli_query($dbc, $query) or die("ERROR S");
}else{
	header("Location: ../search/searchProfessors.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <body>
    <div id="header">Group 5</div>
    <a href="../search/searchProfessors.php"><div id="back">Back</i></div></a>
    <div id="container">

        <h1>Professor Information</h1>
				<div class="group">
					<label for ="profName">Professor Name</label><br>
					 <input type="text" name="profName" value="<?php echo $nameDept['profName']; ?>" readonly>
				</div>
				<div class="group">
					<label for ="courseCode">Course Code</label><br>
					 <input type="text" name="courseCode" value="<?php echo $currCourse['courseCode']; ?>" readonly>
				</div>
				<div class="group">
					<label for ="ratings">Ratings</label><br>
					<table name='ratings' border='1'><?php
						echo "<tr>";
						$tableHeadings = array(
							"GRADING",
							"LENIENCY",
							"STRICTNESS"
						);
						$arrlength = count($tableHeadings);
    
						for ($x = 0; $x < $arrlength; $x++) {
							echo "<td>" . $tableHeadings[$x] . "</td>";
						}
						echo "</tr><tr>";
						while ($rating = mysqli_fetch_assoc($ratingResult)) {
							//ADD HERE
							echo "<td>{$rating['aveRating']}</td>";
						}
						echo "</tr>";
					?></table>
				</div>
				<div class="group">
					<label for ="middlename">Home Department</label><br>
					<input type="text" name="homeDept" value="<?php echo $nameDept['departmentName']; ?>" readonly>
				</div>
				<div class="group">
					<label for ="lastname">Courses Taught</label><br>
					<input type="text" name="coursesTaught" value="<?php 
					$first = true;
					while ($course = mysqli_fetch_assoc($courseResult)) {
							if($first){
								echo "{$course['courseCode']}";
							}else{
								echo ", {$course['courseCode']}";
							}
							$first = false;
						} ?>" readonly>
				</div>
				<div class="group">
					<label for ="sex">Reviews</label><br>
					<input type="text" name="reviews" value="<?php echo "hi"; ?>" readonly>
				</div>

        <a href="../rate/rateProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>"><input type="submit" value="Rate Professor" /></i></a><br>
		<a href="../rate/reviewProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>"><input type="submit" value="Review Professor" /></i></a><br>

     

    </div>

  </body>
</html>
