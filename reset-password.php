<?php

// include "config.php";

// if(isset($_POST['submit'])) {
//     $email = mysqli_real_esacpe_string($conn, $_POST['email']);

//     $emailquery = "SELECT * FROM user WHERE email='$email'";
//     $query = mysqli_query($conn, $emailquery);

    // inputted email id hamare table ki kisi row mai match krta hai ki nhi
    // $emailcount = mysqli_num_rows($query);
    // if($emailcount) {

    //     $userdata = mysqli_fetch_array($query);
    //     $username = $userdata['username'];
    //     $token = $userdata['token'];

    //     $subject = "Password Reset";
    //     $body = "Hi, $username. Click here to reset your password.";
    //     $sender_email = "From: hirva.dhandhukia@gmail.com";

    //     if(mail($email, $subject, $body, $sender_email)) {
    //         $_SESSION['msg'] = "check your mail to reset your password $email";
    //         header('location:login.php');
    //     } else {
    //         echo "failed to send the email... ";
    //     }
        
    // } else {
    //     echo "No email found in database";
    // }
// }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover your account</title>
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
    <h3 style="margin-bottom: 4px;">Reset your password:</h3>
    <hr size="0">

    <form action="" method="post">
        <div class="form-div col-flex12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="email write" id="email" placeholder="Enter your email">
            <small>An e-mail will be send to you with the instructions on how to reset your password.</small>
        </div>

        <div class="form-div">
            <button type="submit" name="submit" class="btn">Send Mail</button>
            <!-- <button type="submit" name="reset-request-submit" class="btn">Send Mail</button> -->
        </div>

    </form>
    </div>

</body>
</html>