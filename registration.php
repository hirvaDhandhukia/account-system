<?php

require_once "config.php";
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

if($_SERVER['REQUEST_METHOD']=="POST") {
    // check if username is empty
    if(empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    }
    else {
        // preparing a select statement
        $sql = "SELECT id FROM user WHERE username = ?";
        // ab mai mere variable ko bind karungi statement se
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // now jiske sath bind kia wo variable ko set krungi
            // set the value of param_username
            $param_username = trim($_POST['username']);

            //ab ham ye statement ko execute krne ka try karenge
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt); 

                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                } else {
                    $username = trim($_POST['username']);
                }
            } 
            else {
                echo "Something went wrong";
            }
            mysqli_stmt_close($stmt);
        }
    }


    // check for password
    if(empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif(strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

    //check for confirm_password field
    if(trim($_POST['confirm_password']) != trim($_POST['password'])) {
        $confirm_password_err = "Passwords should match";
    }

    //check for email
    // if(empty(trim($_POST['email']))) {
    //     $email_err = "Email cannot be blank";
    // } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     $email_err = "Invalid email format. Try using name@example.com format";
    // } else {
    //     $email = trim($_POST['email']);
    // }
    $email = trim($_POST['email']);


    // if there were no errors, insert the values into the database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        // generating a sql query
        $sql = "INSERT INTO user (username, password, email) VALUES (?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        // yaha pr statement prepare kii. 1st argument connection rahega and second argument sql hoga
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);

            // ab ye parameters ko set karenge
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;

            // trying to execute the query
            if(mysqli_stmt_execute($stmt)) {
                header("location: login.php");
            } else {
                echo "Something went wrong... cannot redirect";
            }
        }
        mysqli_stmt_close($stmt);
    }
    else {
        echo "error occured";
    }
    mysqli_close($conn);

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Techsevin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navigation container">
        <div class="nav-brand">
            <a href="#" class="nav-brand link">TECHSEVIN</a>
        </div>
        <ul class="list-non-bullet nav-pills">
            <li class="list-item-inline">
                <a href="#" class="link active">Registration</a>
            </li>
            <li class="list-item-inline">
                <a href="login.php" class="link">Login</a>
            </li>
            <li class="list-item-inline">
                <a href="logout.php" class="link">Logout</a>
            </li>
        </ul>
    </nav>


    <!-- registration form -->
    <div class="form-container">
        <h3 style="margin-bottom: 4px;">Register Here:</h3>
        <hr size="0">

    <form action="" method="post">
        <div class="form-div col-flex6">
            <label class="form-label">First Name</label>
            <input type="text" name="fname" class="fname write" id="fname" placeholder="First Name">
            <span id="fname_err"></span>
        </div>
        <div class="form-div col-flex6">
            <label class="form-label">Last Name</label>
            <input type="text" name="lname" class="lname write" id="lname" placeholder="Last Name">
            <span id='lname_err'></span>
        </div>
        <div class="form-div col-flex12">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="username write" id="username" placeholder="Username">
            <span id="username_err"><?php echo $username_err ?></span>
        </div>
        <div class="form-div col-flex12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="email write" id="email" placeholder="name@example.com">
            <span id="email_err"><?php echo $email_err ?></span>
        </div>
        
        <div class="form-div col-flex12">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="address write" id="address" placeholder="Address">
        </div>

        <div class="form-div col-flex6">
            <label class="form-label">City</label>
            <select name="city" id="city" class="write">
                <option selected value="-1"></option>
                <option value="1">Ahmedabad</option>
                <option value="2">Mumbai</option>
                <option value="3">Delhi</option>
                <option value="4">Bangalore</option>
                <option value="4">Udaipur</option>
            </select>
            <span id="city_err"></span>
        </div>
        <div class="form-div col-flex6">
            <label class="form-label" for="date">Birth Date</label>
            <input type="date" name="date" id="date" class="write">
            <span id="date_err"></span>
        </div>

        <div class="form-div col-flex12">
            <label class="form-label">Gender</label>
            <div class="form-div-gender">
                <input type="radio" name="gender" id="male" class="radio-inp">
                <label for="male">Male</label>
                <input type="radio" name="gender" id="female" class="radio-inp">
                <label for="female">Female</label>
                <input type="radio" name="gender" id="other" class="radio-inp">
                <label for="other">Other</label>
            </div>
            <span id="gender_err"></span>
        </div>

        
        <div class="form-div col-flex6">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="password write" id="password" placeholder="Password">
            <span id="password_err"><?php echo $password_err ?></span>
        </div>
        <div class="form-div col-flex6">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="confirm_password write" id="confirm_password" placeholder="Confirm Password">
            <span id="confirm_password_err"><?php echo $confirm_password_err ?></span>
        </div>


        <div class="form-div col-flex12">
            <label for="box"><input type="checkbox" name="checkbox" id="checkbox"> Create my account</label>
            <span id="checkbox_err"></span>
        </div>
        <div class="form-div">
            <button type="submit" class="btn">Sign in</button>
        </div>
    </form>
    </div>

    <!-- <script src="jquery-3.6.0.min.js"></script> -->
    <!-- <script type="text/javascript" src="app.js"></script> -->
</body>
</html>