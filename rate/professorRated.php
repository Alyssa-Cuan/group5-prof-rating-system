<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <body>

<?php
$s_dataName  = array();
$s_dataValue = array();
$ID          = "";
$CID         = "";
$arrlength   = "";
if (isset($_GET['ID']) && isset($_GET['CID']) && isset($_GET['headingsCount'])) {
    require_once '../connect/connect.php';
    $ID        = mysqli_real_escape_string($dbc, $_GET['ID']);
    $CID       = mysqli_real_escape_string($dbc, $_GET['CID']);
    $arrlength = mysqli_real_escape_string($dbc, $_GET['headingsCount']);
} else {
    header("Location: ../view/profDataView.php");
}

if (isset($_POST['rateProf'])) {
    $data_missing = array();
    $out          = "";

    foreach ($_POST as $key => $value) {
        
        if ($key == "rateProf") {
            break;
        }
        if (empty($_POST[$key])) {
            // Adds name to array
            $data_missing[] = $key . " ";
            
        } else {
            // Trim white space from the name and store the name
            array_push($s_dataName, $key);
            array_push($s_dataValue, trim($_POST[$key]));
        }
    }
    
?>

    <div id="header">Group 5</div>
    <div id="container">
<?php
    if (empty($data_missing)) {
        
        //inserting the student
        try {
            for ($x = 0; $x < $arrlength; $x++) {
                $SID = $_SESSION['studentID'];
                
                $query = "INSERT INTO rating (ratingName, ratingValue, professorID,
            classID, studentID) VALUES (?,?,?,?,?)";
                
                $stmt = mysqli_prepare($dbc, $query);
                
                $stmt->bind_param("sdiii", $s_dataName[$x], $s_dataValue[$x], $ID, $CID, $SID);
                
                $stmt->execute() or die(mysqli_error($dbc));
            }
        }
        catch (Exception $e) {
            $error = $e->getMessage();
            echo $error;
        }
        
        //redirect to home page maybe?
        $_SESSION['ratedSuccessfully'] = "Rating submitted successfully";
        header("Location: ../view/profDataView.php?ID=$ID&CID=$CID");

        
        
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach ($data_missing as $missing) {
            
            echo "$missing<br />";
            
        }
        
        
    }
    
} else {
    header("Location: ../view/profDataView.php");
}

?>

    </div>
  </body>
</html>