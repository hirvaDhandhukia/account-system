<?php

//this script will handle login
// yaha hame session ko start kr leana hai
session_start();

//check if the user is already loggedin
if(isset($_SESSION['username'])) {
    header("location: wecome.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$err = "";

// jese hi form submit hota hai :-
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $err = "Please enter username + password";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }
    
if(empty($err)) {
    $sql = "SELECT id, username, password FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);

    $param_username = $username;

    //try to execute the statement
    if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        // agar username exist krta hai too
        if(mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
            // password verify karenge
            if(mysqli_stmt_fetch($stmt)) {
                if(password_verify($password, $hashed_password))
                {
                    // this means the password is correct, allow user to login
                    session_start();
                    $_SESSION["username"] = $username;
                    $_SESSION["id"] = $id;
                    $_SESSION["loggedin"] = true;

                    // redirect user to welcome page
                    header("location: welcome.php");
                }
            }
        }
    }
}

} 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Techsevin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navigation container">
        <div class="nav-brand">
            <a href="indexx.html" class="nav-brand link">TECHSEVIN</a>
        </div>
        <ul class="list-non-bullet nav-pills">
            <li class="list-item-inline">
                <a href="registration.php" class="link">Registration</a>
            </li>
            <li class="list-item-inline">
                <a href="login.php" class="link active">Login</a>
            </li>
            <li class="list-item-inline">
                <a href="logout.php" class="link">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- login form here -->
    <div class="form-container">
    <h3 style="margin-bottom: 4px;">Login Here:</h3>
    <hr size="0">

    <form action="" method="post">
        <div class="form-div col-flex12">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="username write" id="username" placeholder="Username">
        </div>
        <div class="form-div col-flex12">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="password write" id="password" placeholder="Password">
            <span><?php echo $err ?></span>
        </div>

        <div class="form-div">
            <button type="submit" class="btn">Login</button>
        </div>

        <div class="form-div col-flex12">
            <a href="reset-password.php">Forgot password?</a>
        </div>

    </form>
    </div>

</body>
</html>