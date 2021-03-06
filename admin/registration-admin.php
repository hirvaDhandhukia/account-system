<?php

require_once "../users/includes/config.php";
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

if($_SERVER['REQUEST_METHOD']=="POST") {
    // check if username is empty
    if(empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    }
    else {
        // preparing a select statement to check if the username already exists in the database
        // step1: select the username from database using a select statement
        // step2: prepare that statement and connect it to the $conn
        // step3: now if preparing the statement is successful (i.e. there was no error in the sql statement) then bind the parameters that were marked ?(placeholders)
        // step4: give the values of the params.
        // step5: now that statement got it's ? wali values, you can execute the prepared statement.
        // step6: store the result got after executing the sql statement and then return the $username values. 
        $sql = "SELECT id FROM admin WHERE username = ? OR email = ?;";
        // ab mai mere variable ko bind karungi statement se
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_email);

            // now jiske sath bind kia wo variable ko set krungi
            // set the value of param_username as the value that we have got from user in post method
            $param_username = trim($_POST['username']);
            $param_email = trim($_POST['email']);

            //ab ham ye statement ko execute krne ka try karenge
            // if statement sahi se execute ho gai then,,
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt); 

                // mysqli_stmt_num_rows($stmt) == 1 checks if the value of inputed username already exists, then we will give an error
                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                    $email_err = "This email is already taken";
                } else {
                    $username = trim($_POST['username']);
                }
            } 
            else {
                echo "Something went wrong. Problem with SQL statement";
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
        // creating an sql statement that we want to run into our database. 
        // we use herre ? (prepared statement) so that we donot let any person commming to our website and destroying the database by adding sql statments in the user input fiels
        $sql = "INSERT INTO admin (username, password, email) VALUES (?, ?, ?);";
        // here the ? is called a placeholder

        // create a prepare statement here
        $stmt = mysqli_prepare($conn, $sql);
        // yaha pr statement prepare kii. 1st argument connection rahega and second argument sql hoga
        if($stmt) {
            // now as there are no errors, we need to take the info that the user gave us and put that inside the database and run it with the $sql statement that we prepared above
            // we are going to bind the parameters that user gave us with our prepared statement
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);

            // ab ye parameters ko set karenge
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;

            // trying to execute the query
            // we are executing the parameters with the prepared statement in our database here
            if(mysqli_stmt_execute($stmt)) {
                // echo "<script>alert('Signup successful!')</script>";
                header("location: login-admin.php");
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
    <link rel="stylesheet" href="..\styles\style.css">
</head>
<body>
<nav class="navigation container">
        <div class="nav-brand">
            <a href="#" class="nav-brand link">TECHSEVIN ADMIN</a>
        </div>
        <ul class="list-non-bullet nav-pills">
            <li class="list-item-inline">
                <a href="registration-admin.php" class="link active">Signup</a>
            </li>
            <li class="list-item-inline">
                <a href="login-admin.php" class="link">Login</a>
            </li>
        </ul>
    </nav>


    <!-- registration form -->
    <div class="form-container">
        <h3 style="margin-bottom: 4px;">Admin Sign Up Here:</h3>
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

    <script src="..\js\jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="..\js\app.js"></script>
</body>
</html>