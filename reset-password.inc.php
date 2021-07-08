<?php

// reset password submit btn dabaya hoo to hi ye run hoga warna error dee dega
    if (isset($_POST['reset-password-submit'])) {

        $selector = $_POST["selector"];
        $validator = $_POST["validator"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["confirm_password"];

        // error handling
        if(empty($password) || empty($passwordRepeat)) {
            header("location: create-new-password.php?newpwd=empty&selector=" . $selector . "&validator=" . $validator);
            echo "empty passwords not allowed";
            exit();
        } else if ($password !== $passwordRepeat) {
            header("location: create-new-password.php?newpwd=pwdnotsame&selector=" . $selector . "&validator=" . $validator);
            echo "both passwords don't match. write same passwords";
            exit();
        }

        // start checking for tokens now
        $currentDate = date("U");

        require "config.php";
        $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
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
                    $sql = "SELECT * FROM user WHERE email=?;";
                    $stmt = mysqli_stmt_init($stmt, $sql);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "There was an error!";
                        exit();
                    } else {

                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if(!$row = mysqli_fetch_assoc($result)) {
                            echo "There was an error";
                            exit();
                        } else {

                            //this sql statement below will update the new password to the database
                            $sql = "UPDATE user SET pwdUsers=? WHERE email=?";
                            $stmt = mysqli_stmt_init($stmt, $sql);
                            if(!$mysqli_stmt_prepare($stmt, $sql)) {
                                echo "There was an error!";
                                exit();
                            } else {

                                $newpwdhash = password_hash($password, PASSWORD_DEFAULT);
                            
                                mysqli_stmt_bind_param($stmt, "ss", $newpwdhash, $tokenEmail);
                                mysqli_stmt_execute($stmt);

                                // now we will delete the token created
                                // here ? is called a placeholder
                                $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                                $stmt = mysqli_stmt_init($conn);
                                if(!$mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "There was an error while deleting";
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("location: login.php?newpwd=passwordupdated");
                                }

                            }
                        }

                    }

                }
            } 
        }


    } else {
        echo "error happened redirecting!";
        // header("location: welcome.php");
    }

?>