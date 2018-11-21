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
$ID          = "";
$CID         = "";

if (isset($_GET['ID']) && isset($_GET['CID'])) {
    require_once '../connect/connect.php';
    $ID        = mysqli_real_escape_string($dbc, $_GET['ID']);
    $CID       = mysqli_real_escape_string($dbc, $_GET['CID']);
} else {
    header("Location: ../view/profDataView.php");
}

if (isset($_POST['reviewProf'])) {
    $data_missing = array();	

	if(empty($_POST["review"])){
    // Adds name to array
    $data_missing[] = "Review Text ";

    } else {
        // Trim white space from the name and store the name
        $s_review = trim($_POST["review"]);
    }
    
    
?>

    <div id="header">Group 5</div>
    <div id="container">
<?php
    if (empty($data_missing)) {
        
        //inserting the student
        try {
			@require_once '../connect/connect.php';
            $SID = $_SESSION['studentID'];
                
            $query = "INSERT INTO review (reviewText, professorID,
            classID, studentID) VALUES (?,?,?,?)";
                
            $stmt = mysqli_prepare($dbc, $query);
                
            $stmt->bind_param("siii", $s_review, $ID, $CID, $SID);
                
            $stmt->execute() or die(mysqli_error($dbc));
            
        }
        catch (Exception $e) {
            $error = $e->getMessage();
            echo $error;
        }
        
        //redirect to home page maybe?
        $_SESSION['reviewedSuccessfully'] = "Review submitted successfully";
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