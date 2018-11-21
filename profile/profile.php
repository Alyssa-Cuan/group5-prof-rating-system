<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location: ../index.php");
}
?>
<?php
require_once '../connect/connect.php';
$SID = $_SESSION['studentID'];
//get the prof name and home dept
$query = "SELECT CONCAT(firstName, ' ', middleName, ' ', lastName) AS profName, courseCode FROM professor, class, studentprofclass WHERE studentprofclass.studentID='$SID' AND studentprofclass.professorID = professor.professorID AND studentprofclass.classID = class.classID";
$nameClassResult = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
?>
<!DOCTYPE html>
<html lang="en">
<body>
<div id="container">

    <h1>Profile Information</h1>
    <div class="group">
        <label for ="username"><?php echo $_SESSION['login_user']; ?></label><br>
        <label for ="savedProfs">Saved Professors:</label><br>
        <?php
        while ($nameClass = mysqli_fetch_assoc($nameClassResult)) {
            echo "<label for='saved[]'>{$nameClass['profName']} -- {$nameClass['courseCode']}</label><br>";
        }

        ?>
    </div>
</div>

</body>
</html>