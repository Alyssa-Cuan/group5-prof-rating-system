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
	$courseTaughtResult = mysqli_query($dbc, $query) or die("ERROR S");
	
	$query = "SELECT CONCAT('p', '', professorID) AS professorID, CONCAT(lastName, ', ', firstName, ' ', middleName) AS profName FROM professor";
$nameResult = mysqli_query($dbc, $query) or die("ERROR S");

//get the classID, courseName
$query = "SELECT CONCAT('c', '', classID) AS classID, CONCAT(courseCode, ' - ', courseName) AS course FROM class";
$courseResult = mysqli_query($dbc, $query) or die("ERROR S");

//get the department
$query = "SELECT CONCAT('d', '', departmentID) AS departmentID, departmentName FROM department";
$departmentResult = mysqli_query($dbc, $query) or die("ERROR S");

}else{
	header("Location: ../search/searchProfessors.php");
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />

    <title>Professor Name</title>

    <!-- Custom styles for this template -->
    <link href="../style.css" rel="stylesheet" />
	
	    <style type="text/css">
        .autocomplete {
            /*the container must be positioned relative:*/
            position: relative;
            display: inline-block;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }
        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }
        .autocomplete-items div:hover {
            /*when hovering an item:*/
            background-color: #e9e9e9;
        }

        .homeCon {
            margin-top: 100px;
        }

        @media only screen and (max-width: 1200px) {
            .homeCon {
                margin-top: 700px;
            }
        }

        @media only screen and (max-width: 1100px) {
            .homeCon {
                margin-top: 250px;
            }
        }

        @media only screen and (max-width: 765px) {
            .homeCon {
                margin-top: 800px;
            }
        }

        @media only screen and (max-width: 700px) {
                .homeCon {
                    margin-top: 700px;
                }
            }

        @media only screen and (max-width: 500px) {
            .homeCon {
                margin-top: 750px;
            }
        }


        .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: DodgerBlue !important;
            color: #ffffff;
        }



    </style>
  </head>

  <body class="bg-blue">
    <!-- Navbar -->

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
      <a href="#" class="navbar-left"><img src="../assets/logo.png" class="logo"/></a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarCollapse"
        aria-controls="navbarCollapse"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
         <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="../homepage/home.php">
              Home <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item"><a class="nav-link" href="../profile/profile.php">Profile</a></li>
		   <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){ ?>
                <li class="nav-item"><a class="nav-link" href="../addAsAdmin/addDepartments.php">Add Dept</a></li>
                <li class="nav-item"><a class="nav-link" href="../addAsAdmin/addClasses.php">Add Class</a></li>
                <li class="nav-item"><a class="nav-link" href="../addAsAdmin/addProfessors.php">Add Prof</a></li>
                <li class="nav-item"><a class="nav-link" href="../addAsAdmin/addClassToProf.php">Add Class to Prof</a></li>
            <?php } ?>
          <li class="nav-item"><a class="nav-link" href="../home/logout.php">Logout</a></li>
        </ul>
        <form class="form-inline my-2 my-lg-0"  autocomplete="off" action="../search/searchProfessor.php" method="post">
            <div class="autocomplete">
                <input type="hidden" id="selectedID" name="selectedID" value="" >
                <input class="form-control mr-sm-2" id="myInput" name="data" type="text"  placeholder="Search">

            </div>
            <button class="btn btn-primary btn-outline-light my-2 my-sm-0" type="submit">Search</button>
        </form>

        <script type="text/javascript" language="javascript">
            var data = new Array();
            <?php while ($name = mysqli_fetch_assoc($nameResult)) { ?>
            data.push({name: '<?php echo $name['profName']; ?>', code: '<?php echo $name['professorID']; ?>'});
            <?php } ?>

            <?php while ($course = mysqli_fetch_assoc($courseResult)) { ?>
            data.push({name: '<?php echo $course['course']; ?>', code: '<?php echo $course['classID']; ?>'});
            <?php } ?>

            <?php while ($department = mysqli_fetch_assoc($departmentResult)) { ?>
            data.push({name: '<?php echo $department['departmentName']; ?>', code: '<?php echo $department['departmentID']; ?>'});
            <?php } ?>

            function autocomplete(inp, arr) {
                /*the autocomplete function takes two arguments,
                the text field element and an array of possible autocompleted values:*/
                var currentFocus;
                /*execute a function when someone writes in the text field:*/
                inp.addEventListener("input", function(e) {
                    var a, b, i, val = this.value;
                    /*close any already open lists of autocompleted values*/
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    /*create a DIV element that will contain the items (values):*/
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");
                    /*append the DIV element as a child of the autocomplete container:*/
                    this.parentNode.appendChild(a);
                    /*for each item in the array...*/
                    for (i = 0; i < arr.length; i++) {
                        /*check if the item starts with the same letters as the text field value:*/
                        var index = arr[i].name.toUpperCase().indexOf(val.toUpperCase());
                        if (index != -1) {
                            /*create a DIV element for each matching element:*/
                            b = document.createElement("DIV");
                            /*make the matching letters bold:*/
                            b.innerHTML = arr[i].name.substr(0, index);
                            b.innerHTML += "<strong>" + arr[i].name.substr(index, val.length) + "</strong>";
                            b.innerHTML += arr[i].name.substr(index+val.length);

                            /*insert a input field that will hold the current array item's value:*/
                            b.innerHTML += "<input type='hidden' value='" + arr[i].name + "'>";
                            b.innerHTML += "<input type='hidden' name='searchCode' value='" + arr[i].code + "'>";
                            /*execute a function when someone clicks on the item value (DIV element):*/
                            b.addEventListener("click", function(e) {
                                /*insert the value for the autocomplete text field:*/
                                inp.value = this.getElementsByTagName("input")[0].value;
                                document.getElementById("selectedID").value = this.getElementsByTagName("input")[1].value;
                                /*close the list of autocompleted values,
                                (or any other open lists of autocompleted values:*/
                                closeAllLists();
                            });
                            a.appendChild(b);
                        }
                    }
                });
                /*execute a function presses a key on the keyboard:*/
                inp.addEventListener("keydown", function(e) {
                    var x = document.getElementById(this.id + "autocomplete-list");
                    if (x) x = x.getElementsByTagName("div");
                    if (e.keyCode == 40) {
                        /*If the arrow DOWN key is pressed,
                        increase the currentFocus variable:*/
                        currentFocus++;
                        /*and and make the current item more visible:*/
                        addActive(x);
                    } else if (e.keyCode == 38) { //up
                        /*If the arrow UP key is pressed,
                        decrease the currentFocus variable:*/
                        currentFocus--;
                        /*and and make the current item more visible:*/
                        addActive(x);
                    } else if (e.keyCode == 13) {
                        /*If the ENTER key is pressed, prevent the form from being submitted,*/
                        e.preventDefault();
                        if (currentFocus > -1) {
                            /*and simulate a click on the "active" item:*/
                            if (x) x[currentFocus].click();
                        }
                    }
                });
                function addActive(x) {
                    /*a function to classify an item as "active":*/
                    if (!x) return false;
                    /*start by removing the "active" class on all items:*/
                    removeActive(x);
                    if (currentFocus >= x.length) currentFocus = 0;
                    if (currentFocus < 0) currentFocus = (x.length - 1);
                    /*add class "autocomplete-active":*/
                    x[currentFocus].classList.add("autocomplete-active");
                }
                function removeActive(x) {
                    /*a function to remove the "active" class from all autocomplete items:*/
                    for (var i = 0; i < x.length; i++) {
                        x[i].classList.remove("autocomplete-active");
                    }
                }
                function closeAllLists(elmnt) {
                    /*close all autocomplete lists in the document,
                    except the one passed as an argument:*/
                    var x = document.getElementsByClassName("autocomplete-items");
                    for (var i = 0; i < x.length; i++) {
                        if (elmnt != x[i] && elmnt != inp) {
                            x[i].parentNode.removeChild(x[i]);
                        }
                    }
                }
                /*execute a function when someone clicks in the document:*/
                document.addEventListener("click", function (e) {
                    closeAllLists(e.target);
                });
            }

        </script>

        <script>
            autocomplete(document.getElementById("myInput"), data);
        </script>
      </div>
    </nav>

    <!-- content -->
    <main role="main" class="container homeCon">

        <div class="row">
  
          <div class="col-lg mx-auto col-md-6 order-md-1 bg-blue">
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
              <h2>Professor Information</h2>
  
            <ul class="list-group">
              <li class="list-group-item bg-blue">
                <?php echo $nameDept['profName']; ?>
              </li>
              <li class="list-group-item bg-blue">Course Code - <?php echo $currCourse['courseCode']; ?></li>
            </ul>
            <table name="ratings" class="table table-striped table-bordered">
              <?php
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
						?>
            </table>
  
            <ul class="list-group pb-3">
              <li class="list-group-item bg-blue">Home Department - <?php echo $nameDept['departmentName']; ?></li>
              <li class="list-group-item bg-blue">
                Courses Taught - <?php 
					$first = true;
					while ($courseTaught = mysqli_fetch_assoc($courseTaughtResult)) {
							$courseC = $courseTaught['courseCode'];
							if($first){
								echo $courseC;
							}else{
								echo ", " . $courseC;
							}
							$first = false;
						} ?>
              </li>
            </ul>
            <div class="d-flex flex-column">
			<a href="../rate/rateProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>">
              <button
                class="btn btn-primary btn-outline-primary my-2 my-sm-0"
				style="width:100%"
                type="submit"
              >
			
                Rate Professor
              </button>
			    </a>
				
				<a href="../rate/reviewProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>">
              <button
			  style="width:100%"
                class="btn btn-primary btn-outline-primary my-2 my-sm-0"
                type="submit"
              >
                Review Professor
              </button>
			  </a>
			  
			 
                  <?php
        //get the prof name and home dept
        $query = "SELECT * FROM studentprofclass WHERE professorID = '$ID' AND classID = '$CID' AND studentID = '$SID'";
        $saveResult = mysqli_query($dbc, $query) or die("ERROR S");
        if(mysqli_num_rows($saveResult) >= 1){ ?>
            <a href="../save/saveProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>"><button
                class="btn btn-primary btn-outline-primary my-2 my-sm-0" style="width:100%" 
                type="submit">Unsave Professor</button></a><br>
        <?php }else{ ?>
            <a href="../save/saveProfessor.php?ID=<?php echo $ID; ?>&CID=<?php echo $CID; ?>"><button
                class="btn btn-primary btn-outline-primary my-2 my-sm-0" style="width:100%" 
                type="submit">Save Professor</button></a><br>
        <?php } ?>
			  
              
            </div>
          </div>
  
          <div class="col-lg mx-auto col-md-4 col-sm-1 order-md-2"  >
            <h2>Reviews</h2>
            <ul class="list-group" style="height: 500px; width: 520px; overflow: scroll">
                
                 <?php 
						while ($review = mysqli_fetch_assoc($reviewResult)) {
							echo '<li class="list-group-item bg-blue" style="word-wrap:break-word;">' . $review['reviewText'] .'</li>';
						}

					?>                                      
              </ul>
            </div>
          </div>
        </div>
      </main>
    <!-- /.container -->

    <!--
      JavaScript
      ==================================================
    -->

    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
	
	
		
		
  </body>
</html>
