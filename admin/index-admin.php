<?php

session_start(); 
require_once "../users/includes/config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserAccount | Techsevin</title>
    <link rel="stylesheet" href="..\styles\style.css"/>
</head>
<body>
<nav class="navigation container">
        <div class="nav-brand">
            <a href="#" class="nav-brand link">TECHSEVIN ADMIN</a>
        </div>
        <ul class="list-non-bullet nav-pills">
        <?php
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!== true) { 
            // i.e. user is not logged in (loggedin session is false)
            echo '<li class="list-item-inline">
                    <a href="registration-admin.php" class="link">Signup</a>
                </li>
                <li class="list-item-inline">
                    <a href="login-admin.php" class="link">Login</a>
                </li>';
        } else {
            // user is logged in successfully
            echo ' <li class="list-item-inline">
                    <a href="userinfo.php" class="link">User-Info</a>
                </li>
                <li class="list-item-inline">
                    <a href="profile-admin.php" class="link">Profile Page</a>
                </li>
                <li class="list-item-inline">
                    <a href="logout-admin.php" class="link">Logout</a>
                </li>';
        }
        ?>
        </ul>
    </nav>

    <div style="margin-top: 10px;">
    <?php
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!== true) { 
        echo '<p>You are logged out! Press the Login button to login or Signup button to signup...</p>';
    } else {
        echo '<p>You are logged in successfully!</p>';
        echo '<h1>Welcome, '. $_SESSION["username"] .'</h1>';
            
    $username = $_SESSION["username"];
    $sql = "SELECT * FROM admin WHERE username='$username';";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // we want to get the id of user who is loggedin inside the user table. $id ke andar user-table ke id ki info store karwa di. 
            $id = $row['id'];
            $sqlImg = "SELECT * FROM profileimg WHERE userid='$id';";
            $resultImg = mysqli_query($conn, $sqlImg);
            while($rowImg = mysqli_fetch_assoc($resultImg)) {
                echo "<div class='user-container'>";
                if($rowImg['status'] == 0) {
                    echo "<img src='../uploads/admin/profile".$id.".jpg'>";
                } else {
                    echo "<img src='../uploads/profiledefault.jpg'>";
                }
                echo $row['username'];
                echo "</div>";
            }
        }
    } else {
        echo "Error!.";
    }
    // form for uploading the profile image
    echo "<form action='includes/upload.inc.php' method='post' enctype='multipart/form-data'>
    <input type = 'file' name='file'>
    <button type='submit' name='submitImg'>UPLOAD</button>
    </form>";
    }
    ?>  
    </div>

    <?php
        if(isset($_GET["upload"])) {
            if($_GET["upload"] == "success") {
                echo '<p>Your profile image has been uploaded!</p>';
            }
        }
    ?> 

</body>
</html>