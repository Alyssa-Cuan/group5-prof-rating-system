<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location: ../index.php");
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
    <link rel="icon" href="../assets/login.png" />

    <title>Search</title>

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet" />

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
        .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

    </style>

    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-dt/css/jquery.dataTables.css">



    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <link href="signin.css" rel="stylesheet">

</head>

<?php
require_once '../connect/connect.php';


//get the profID, prof name
$query = "SELECT CONCAT('p', '', professorID) AS professorID, CONCAT(lastName, ', ', firstName, ' ', middleName) AS profName FROM professor";
$nameResult = mysqli_query($dbc, $query) or die("ERROR S");

//get the classID, courseName
$query = "SELECT CONCAT('c', '', classID) AS classID, CONCAT(courseCode, ' - ', courseName) AS course FROM class";
$courseResult = mysqli_query($dbc, $query) or die("ERROR S");

//get the department
$query = "SELECT CONCAT('d', '', departmentID) AS departmentID, departmentName FROM department";
$departmentResult = mysqli_query($dbc, $query) or die("ERROR S");


?>

<body class="bg-blue">
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
            <li class="nav-item active">
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
            <li class="nav-item"><a class="nav-link" href="../homepage/logout.php">Logout</a></li>
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