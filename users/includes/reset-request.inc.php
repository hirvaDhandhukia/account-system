<?php

// isset is used to make shure that the user has submitted the email and pressed the submit btn 
if(isset($_POST['reset-request-submit'])) {

    // a token has to be made cryptographically secure and we use build in php functions
    // we are going to use 2 tokens. 1 token to actually authenticate that this is the correct user. 2nd one we use to look inside the database to pinpoint the token when they actucally get back to the website
    // by using 2 different tokens, we prevent to something called timing attacks.
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    //$token authenticates if the user is correct or not

    // we here now, create the link that we are going to send to the user in e-mail
    $url = "www.localhost/account-system/users/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    // we can grab these selector= and validator= afterwords using get method

    // now we are gonna create an expiary date for our token, we don't want the link to work for infinite time.
    $expires = date("U") + 1800;

    require "config.php";
    $userEmail = $_POST["email"];

    // first thing we need to do is to delete the existing tokens from our database for a particular user. we don't want any user to have access to multiple tokens at the same time.
    $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        // error msg
        echo "there was an error";
        exit();
    } else {
        // below here bind_param is telling what is going to replace the '?' before we execute the $sql statement
        // "s" means string datatype
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }


    // now that any prior data of that user is deleted, we are going to insert the token inside our database
    $sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
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

    header("location: ../reset-password.php?reset=success");

} else {
    echo "error happened";
    // header("location: ../index.php");
}



// step 1: create 2 tokens and expiry date for token.
// step 2: delete all the prior tokens if they exist (bec. we don't want the user to have more than 1 token at a single time);
// step 3: now insert our token into the database and generte a url that we are going to send to user
// step 4: now that the tokens are set, we are gonna send an email to user with the url inside it so that he/she can click on it which will redirect them to a page for create-new-password. 
// step 5: after the mail is successsfully sent, give a get method handler to show if the reset=success. and redirect the user to the site.