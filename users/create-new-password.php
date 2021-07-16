<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send-reset-passmail | Techsevin</title>
    <link rel="stylesheet" href="..\styles\style.css">
</head>
<body>

    <nav class="navigation container">
        <div class="nav-brand">
            <a href="#" class="nav-brand link">TECHSEVIN</a>
        </div>
        <ul class="list-non-bullet nav-pills">
            <li class="list-item-inline">
                <a href="registration.php" class="link">Registration</a>
            </li>
            <li class="list-item-inline">
                <a href="login.php" class="link active">Login</a>
            </li>
            <li class="list-item-inline">
                <a href="includes/logout.inc.php" class="link">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- login form here -->
    <div class="form-container">
    <h3 style="margin-bottom: 4px;">Your new password:</h3>
    <hr size="0">

    <?php
    // before giving for the tokens, we need to check if the tokens are inside the url && after we reset the password, we again need to recheck for the tokens
    // grabbing the tokens from the url 
        $selector = $_GET["selector"];
        $validator = $_GET["validator"];

        if(empty($selector) || empty($validator)) {
            //error msg
            // this all is just to make shure that nobody is messing with your tokens and url
            echo "we could not validate your request, tokens are empty in the url";
        } else {
            // here we check of the hexadecimal token is actually hexadecimal or not with an inbuilt function of php
            if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {
    ?>

        <form action="includes/reset-password.inc.php" method="post">

                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">

        <div class="form-div col-flex6">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="password write" id="password" placeholder="Enter new password">
        </div>
        <div class="form-div col-flex6">
            <label class="form-label">Confirm the New Password</label>
            <input type="password" name="confirm_password" class="confirm_password write" id="confirm_password" placeholder="Repeat new password">
        </div>
        <div class="form-div">
            <button type="submit" name="reset-password-submit" class="btn">Reset Password</button>
        </div>
    </form>

    <?php
        } else {
            echo '<p>Hexadecimal tokens not found.</p>';
        }
    }
    ?>

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