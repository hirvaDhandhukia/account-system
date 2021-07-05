<?php

// require once config (database se connectn)
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER['REQUEST_METHOD']=='POST') {

    //check for username
    if(empty(trim($_POST['username']))) {
        $username_err = "Username cannot be blank";
    }
    else {
        $sql = "SELECT id FROM user WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            //set the value of param_username
            $param_username = trim($_POST['username']);

            //try to execute this statement
            if(mysql_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something went wrong";
            }
        }
    }
    mysqli_stmt_close($stmt);

//check for password
if(empty(trim($_POST['password']))) {
    $password_err = "Password cannot be blank";
} elseif(strlen(trim($_POST['password'])) < 5) {
    $password_err = "Password cannot be less than 5 characters";
} else {
    $password = trim($_POST['password']);
}

//check for confirm password
if(empty(trim($_POST['confirm_password']))) {
    $confirm_password_err = "Confirm your password here";
} elseif(trim($_POST['confirm_password']) != trim($_POST['password'])) {
    $confirm_password_err = "Passwords should match";
}

// check for first name
if(empty(trim($_POST['fname']))) {
    $fname_err = "First name cannot be blank";
} else {
    $fname = trim($_POST['fname']);
}
//check for last name
if(empty(trim($_POST['lname']))) {
    $lname_err = "Last name cannot be blank";
} else {
    $lname = trim($_POST['lname']);
}

// check for email
if (empty(trim($_POST["email"]))) {
    $email_err = "Email is required";
} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_err = "Invalid email format. Try name@example.com format.";
} else {
    $email = trim($_POST['email']);
}

// check for address
// not putting any validation. Not required.
$address = trim($_POST['address']);

// city. required
if($_POST['city'] == -1) {
    $city_err = "Please select one on the list";
} else {
    $city = trim($_POST['city']);    
}
// birthdate
$birthdate = trim($_POST['date']);
// gender
$gender = trim($_POST[['gender']]);
// checkbox
$box = trim($_POST['box']);


// if there were no error, then go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
    $sql = "INSERT INTO user (username, password) VALUES (?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        //try to execute this INSERT query
        if(mysqli_stmt_execute($stmt)) {
            //header se hamlog redirect krte hai
            header("location: login.php");
        } else {
            echo "Somethin went wrong.. cannot redirect!";
        }
    }
    // statement ko pehle close kia
    mysqli_stmt_close();
}
// statement ko close krne ke baad hamne sql ko close kia
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
            <span><?php echo $fname_err ?></span>
        </div>
        <div class="form-div col-flex6">
            <label class="form-label">Last Name</label>
            <input type="text" name="lname" class="lname write" id="lname" placeholder="Last Name">
            <span><?php echo $lname_err ?></span>
        </div>
        <div class="form-div col-flex12">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="username write" id="username" placeholder="Username">
            <span><?php echo $username_err ?></span>
        </div>
        <div class="form-div col-flex12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="email write" id="email" placeholder="name@example.com">
            <span><?php echo $email_err ?></span>
        </div>
        
        <div class="form-div col-flex12">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="address write" id="address" placeholder="Address">
            <span><?php echo $address_err ?></span>
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
            <span><?php echo $city_err ?></span>
        </div>
        <div class="form-div col-flex6">
            <label class="form-label" for="date">Birth Date</label>
            <input type="date" name="date" id="date" class="write">
            <span><?php echo $date_err ?></span>
        </div>

        <div class="form-div col-flex12">
            <label class="form-label">Gender</label>
            <div class="form-div-gender">
                <input type="radio" name="male" id="male" class="radio-inp">
                <label for="male">Male</label>
                <input type="radio" name="female" id="female"   class="radio-inp">
                <label for="female">Female</label>
                <input type="radio" name="other" id="other"     class="radio-inp">
                <label for="other">Other</label>
            </div>
            <span><?php echo $gender_err ?></span>
        </div>

        
        <div class="form-div col-flex6">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="password write" id="password" placeholder="Password">
            <span><?php echo $password_err ?></span>
        </div>
        <div class="form-div col-flex6">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="confirm_password write" id="confirm_password" placeholder="Confirm Password">
            <span><?php echo $confirm_password_err ?></span>
        </div>


        <div class="form-div col-flex12">
            <label for="box"><input type="checkbox" name="box" id="box"> Create my account</label>
            <span><?php echo $checkbox_err ?></span>
        </div>
        <div class="form-div">
            <button type="submit" class="btn">Sign in</button>
        </div>
    </form>
    </div>

</body>
</html>