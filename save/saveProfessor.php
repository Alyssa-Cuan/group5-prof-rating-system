<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location: ../index.php");
}
?>
<?php
require '../connect/connect.php';
$ID = mysqli_real_escape_string($dbc, $_GET['ID']);
$CID = mysqli_real_escape_string($dbc, $_GET['CID']);
$SID = $_SESSION['studentID'];


$query = "SELECT * FROM studentprofclass WHERE professorID = '$ID' AND classID = '$CID' AND studentID = '$SID'";
$saveResult = mysqli_query($dbc, $query) or die("ERROR S");

if(mysqli_num_rows($saveResult) >= 1){
    $query = "DELETE FROM studentprofclass WHERE professorID = '$ID' AND classID = '$CID' AND studentID = '$SID'";
    $deleteResult = mysqli_query($dbc, $query) or die("ERROR S");
}else{
    $query = "INSERT INTO studentprofclass (studentID, professorID, classID) VALUES (?,?,?)";

    $stmt = mysqli_prepare($dbc, $query);

    $stmt->bind_param("iii", $SID, $ID, $CID);

    $stmt->execute() or die(mysqli_error($dbc));
}

header("Location: ../view/profDataView.php?ID=$ID&CID=$CID")
?>