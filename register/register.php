<?php require 'server.php'; ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Register</title>


    <!-- Custom styles for this template -->
    <link href="../style.css" rel="stylesheet" />

</head>

<body class="bg-blue">

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <a href="#" class="navbar-left"><img src="../assets/logo.png" class="logo"/></a>
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

    <main role="main" class="container">

            <div class="row align-items-center">


                 
                <div class="jumbotron col-lg mx-auto col-md-6 order-md-1 bg-blue">
                    <div class="container">
                        <div class="text-center">
                            <img src="../assets/eagle.png" style="width:35%; height:35%">
                          </div>                                    <h1 class="display-4">Welcome!</h1>
                        <p>This is a place where you can rate your professors as well as see the ratings of other professors in ADMU</p>
                        
                    </div>

                </div>

                <div class="col-lg mx-auto col-md-6 order-md-2">

                    <form class="form-signin border border-secondary rounded" method="post" action="register.php">

                        <h1 class="h3 mb-3 font-weight-normal p-2 pb-4">Register</h1>
                        <label for="username" class="sr-only" >Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                        <label for="inputEmail" class="sr-only">Email address</label>
                        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Enter your obf email" required
                            autofocus>
                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" id="inputPassword" class="form-control" name="password_1" placeholder="Password" required>
                        <label for="confirmPassword" class="sr-only">Confirm Password</label>
                        <input type="password" id="confirmPassword" class="form-control mb-3" name="password_2" placeholder="Confirm Password" required>

                        <button class="btn btn-lg btn-primary btn-circle" name="reg_user" type="submit">Register</button>
                        <p class="text-center p-2">Have an account? <a href="../index.php"> Sign in here</a></p>
                    </form>

                </div>

            </div>
        </main><!-- /.container -->

    <!-- JavaScript
    ================================================== -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>