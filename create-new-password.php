<?php

    if (isset($_POST['reset-password-submit'])) {

        $selector = $_POST["selector"];
        $validator = $_POST["validator"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["confirm_password"];

        // error handling
        if(empty($password) || empty($passwordRepeat)) {
            header("location: create-new-password.php?newpwd=empty");
            exit();
        } else if ($password != $passwordRepeat) {
            header("location: create-new-password.php?newpwd=pwdnotsame");
            exit();
        }

        $currentDate = date("U");

        require "config.php";
        $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
        $stmt = mysqli_stmt_init($conn);
        if(!$mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error!";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $selector);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($result)) {
                echo "You need to re-submit your reset request";
                exit();
            } else {

                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

                if($tokenCheck === false) {
                    echo "error";
                    exit();
                } elseif($tokenCheck === true) {

                    $tokenEmail = $row['pwdResetEmail'];
                    $sql = "SELECT * FROM user WHERE emailUsers=?;";
                    if(!$mysqli_stmt_prepare($stmtm, $sql)) {
                        echo "There was an error!";
                        exit();
                    } else {

                        

                    }

                }
            } 
        }


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
    <h3 style="margin-bottom: 4px;">Your new password:</h3>
    <hr size="0">

    <?php
        $selector = $_GET["selector"];
        $validator = $_GET["validator"];

        if(empty($selector) || empty($validator)) {
            echo "we could not validate your request";
        } else {
            if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {
                ?>

        <form action="" method="post">

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