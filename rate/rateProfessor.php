<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <body>
        <div id="header">Group 5</div>
<div id="container">
<?php
require '../modules/modules.php';
$arrlength     = count($tableHeadings);
if (isset($_GET['ID']) && isset($_GET['CID'])) {
    require_once '../connect/connect.php';
    $ID  = mysqli_real_escape_string($dbc, $_GET['ID']);
    $CID = mysqli_real_escape_string($dbc, $_GET['CID']);
    
    $query = "SELECT CONCAT(firstName, ' ', middleName, ' ', lastName) AS profName, courseCode FROM professor, profclass, class WHERE professor.professorID='$ID' AND class.classID='$CID' AND professor.professorID = profclass.professorID AND profclass.classID = class.classID LIMIT 1";
    $nameCourseResult = mysqli_query($dbc, $query) or die("ERROR S");
    $nameCourse = mysqli_fetch_array($nameCourseResult);
?>
<form action="professorRated.php?ID=<?php
    echo $ID;
?>&CID=<?php
    echo $CID;
?>&headingsCount=<?php
    echo $arrlength;
?>" method="post">
                <div class="group">
                    <label for ="profName">Rating this prof:</label><br>
                    <label for ="profName"><?php
    echo $nameCourse['profName'];
?></label><br>
                </div>
                <div class="group">
                    <label for ="courseCode"><?php
    echo $nameCourse['courseCode'];
?></label><br>
                </div>
    
<?php
    for ($x = 0; $x < $arrlength; $x++) {
        echo "<div class='group'>
                    <label for ='rating'>" . $tableHeadings[$x] . "</label><br>" . "<input type='number' step='0.1' name='$tableHeadings[$x]' value='' min='1' max='5'> </div>";
    }
    
} else {
    header("Location: ../view/profDataView.php");
}
?>
    <div id='buttons'>
        <button type='submit' name='rateProf'>Rate Professor</button>
    </div>
</div>
</form>

  </body>
</html>