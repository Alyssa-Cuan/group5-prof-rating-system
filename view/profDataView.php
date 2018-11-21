<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location: ../index.php");
}
?>
<?php
if(isset($_GET['ID']) && isset($_GET['CID'])){
	require_once '../connect/connect.php';
	$ID = mysqli_real_escape_string($dbc, $_GET['ID']);
	$CID = mysqli_real_escape_string($dbc, $_GET['CID']);
	$SID = $_SESSION['studentID'];
	
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
	
	//get the review
	$query = "SELECT reviewText, professorID FROM review WHERE professorID='$ID' AND classID='$CID'";
	$reviewResult = mysqli_query($dbc, $query) or die("ERROR S");
	
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
    <a href="../search/searchProfessor.php"><div id="back">Back</i></div></a>
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
						require '../modules/modules.php';
						echo "<tr>";
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
					<label for ="review">Reviews</label><br>
					<?php 
						while ($review = mysqli_fetch_assoc($reviewResult)) {
							echo "<input type='text' name='review[]' value='{$review['reviewText']}' readonly><br>";
						}

					?>
				</div>

        <a href="../rate/rateProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>"><input type="submit" value="Rate Professor" /></i></a><br>
		<a href="../rate/reviewProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>"><input type="submit" value="Review Professor" /></i></a><br>

        <?php
        //get the prof name and home dept
        $query = "SELECT * FROM studentprofclass WHERE professorID = '$ID' AND classID = '$CID' AND studentID = '$SID'";
        $saveResult = mysqli_query($dbc, $query) or die("ERROR S");

        if(mysqli_num_rows($saveResult) >= 1){ ?>
            <a href="../save/saveProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>"><input type="submit" value="Unsave Professor" /></i></a><br>
        <?php }else{ ?>
            <a href="../save/saveProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>"><input type="submit" value="Save Professor" /></i></a><br>
        <?php } ?>


        <?php
            if(isset($_SESSION['ratedSuccessfully'])){
                echo $_SESSION['ratedSuccessfully'];
                unset($_SESSION['ratedSuccessfully']);
            }

        if(isset($_SESSION['reviewedSuccessfully'])){
            echo $_SESSION['reviewedSuccessfully'];
            unset($_SESSION['reviewedSuccessfully']);
        }
        ?>
     

    </div>

  </body>
</html>
