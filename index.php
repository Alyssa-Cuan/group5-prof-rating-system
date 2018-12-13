<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message


if (isset($_POST['submit'])) {
	
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "<span style='color:red;'>Invalid Login Details</span>";
    }
    else
    {
        require 'connect/connect.php';
// Define $username and $password
        $username=$_POST['username'];
        $password=$_POST['password'];
// To protect MySQL injection for Security purpose
        $username = mysqli_real_escape_string($dbc, $username);
        $password = mysqli_real_escape_string($dbc, $password);
		
// SQL query to fetch information of registerd users and finds user match.
        $query = "SELECT username, password, role, studentID FROM student WHERE username='$username' AND password='$password'";

        $result = mysqli_query($dbc, $query) or die("Failed");
		

        $rows = mysqli_num_rows($result);
        if ($rows >= 1) {
            $temp = mysqli_fetch_assoc($result);
            $role = $temp['role'];
            $studentID = $temp['studentID'];
            $_SESSION['login_user']=$username; // Initializing Session
            $_SESSION['studentID']=$studentID; // Initializing Session
            $_SESSION ['role']=$role;

            header("location: homepage/home.php");		// Redirecting To Other Page
        } else {
            $error = "<span style='color:red;'>Invalid Login Details</span>";
        }
    }
}

if(isset($_SESSION['registerSuccess'])){
    echo $_SESSION['registerSuccess'];
    unset($_SESSION['registerSuccess']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Welcome</title>


    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet" />

</head>

<body class="bg-blue">

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <a href="#" class="navbar-left"><img src="assets/logo.png" class="logo"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <!-- <li class="nav-item active">
                    <a class="nav-link" href="#">Login <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li> -->
            </ul>

        </div>
    </nav>

    <main role="main" class="container ">

        <div class="container">

            <div class="row align-items-center" style="margin-top: 130px">
                 

                    <div class="container col-lg-6 col-md-6 mx-auto col-sm-6 order-md-1 bg-blue">
                        <div class="text-center">
                            <img src="assets/eagle.png" style="width:35%; height:35%">
                          </div><h1 class="display-4">Welcome!</h1>
                        <p>This is a place where you can rate your professors as well as see the ratings of other professors in ADMU</p>
                        


                </div>

                <div class="mx-auto col-lg-6 col-sm- 1col-md-1 order-md-2">

                    <form class="form-signin border border-secondary rounded" action="" method="post" autocomplete="off">

                        <h1 class="h3 mb-3 font-weight-normal p-2 pb-4">Sign in</h1>
                        <label for="inputEmail" class="sr-only">Username</label>
                        <input type="text" id="username"  name="username" class="form-control" placeholder="Username" required
                            autofocus>
                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" id="password"  name="password" class="form-control" placeholder="Password" required>
                        <div class="checkbox mb-3">
                            <label>
                                <input type="checkbox" value="remember-me"> Remember me
                            </label>
                        </div>
                        <input class="btn btn-lg btn-primary btn-circle" type="submit" name="submit" value="Sign In">
                        <a href="register/register.php"><p class="text-center p-2">No account? Sign up here</p></a>
						<?php if (isset($error) && isset($_POST['submit'])) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
                    </form>

                </div>

            </div>
            
        </div>
    </main><!-- /.container -->

    <!-- JavaScript
    ================================================== -->

    <script src="node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script>window.jQuery || document.write('<script src=".  ./../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/popper.js/dist/popper.min.js"></script>
    <script type="text/javascript" charset="utf8" src="node_modules/datatables.net/js/jquery.dataTables.js"></script>

</body>

</html>