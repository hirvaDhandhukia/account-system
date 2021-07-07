<?php

if(isset($_POST['reset-request-submit'])) {

    // a token has to be made cryptographically secure and we use build in php functions
    // we are going to use 2 tokens. 1 token to actually authenticate that this is the correct user. 2nd one we use to look inside the database to pinpoint the token when they actucally get back to the website
    // by using 2 different tokens, we prevent to something called timing attacks.
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    // we here now, create the link that we are going to send to the user in e-mail
    $url = "www.localhost/account-system/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    // now we are gonna create an expiary date for our token, we don't want the link to work for infinite time.
    $expires = date("U") + 1800;

    require "config.php";
    $userEmail = $_POST["email"];

    // first thing we need to do is to delete the existing tokens from our database for a particular user. we don't want any user to have access to multiple tokens at the same time.
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = mysqli_stmt_init($conn);
    if(!$mysqli_stmt_prepare($stmt, $sql)) {
        // error msg
        echo "there was an error";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!$mysqli_stmt_prepare($stmt, $sql)) {
        // error msg
        echo "there was an error with insertion";
        exit();
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // sending mail to the user 
    $to = $userEmail;
    $subject = 'Reset your password for site';

    $message = '<p>We recieved a password reset request. The link to the reset your password is below.</p>';
    $message .= '<p>Here is your password reset link: </br>';
    $message .= '<a href="' . $url . '">' . $url . '</a></p>';

    $headers = "From: hirva.dhandhukia@gmail.com\r\n";
    $headers .= "Reply-To: hirva.dhandhukia@gmail.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers);

    header("location: reset-passwrod.php?reset=success");

} else {
    header("location: welcome.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send-reset-passmail | Techsevin</title>
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
            <input type="email" name="email" class="email write" id="email" placeholder="Enter your email address">
            <small>An e-mail will be send to you with the instructions on how to reset your password.</small>
        </div>

        <div class="form-div">
            <button type="submit" name="reset-request-submit" class="btn">Send Mail</button>
        </div>

    </form>
    <?php

        if(isset($_GET["reset"])) {
            if($_GET["reset"] == "success") {
                echo '<p>Check your e-mail! Your reset password link is send.</p>';
            }
        }

    ?>
    </div>

</body>
</html>