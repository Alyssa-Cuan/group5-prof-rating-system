<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();

// connect to the database
require '../connect/connect.php';

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = mysqli_real_escape_string($dbc, $_POST['username']);
    $email = mysqli_real_escape_string($dbc, $_POST['email']);
    $password_1 = mysqli_real_escape_string($dbc, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($dbc, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM student WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($dbc, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        //$password = md5($password_1);//encrypt the password before saving in the database

        $role = "regular";

        $query = "INSERT INTO student (studentID, email, username,
            password, role) VALUES (NULL,?,?,?,?)";

        $stmt = mysqli_prepare($dbc, $query);

        $stmt->bind_param("ssss", $email, $username, $password_1, $role);

        $stmt->execute() or die(mysqli_error($dbc));

        $_SESSION['registerSuccess'] = "You have successfully registered, try logging in now.";
        header('location: ../index.php');
    }
}