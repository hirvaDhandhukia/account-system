<?php

session_start(); 
require_once "includes/config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Techsevin</title>
    <link rel="stylesheet" href="..\styles\style.css">
</head>
<body>

<nav class="navigation container">
        <div class="nav-brand">
            <a href="#" class="nav-brand link">TECHSEVIN</a>
        </div>
        <ul class="list-non-bullet nav-pills">
        <?php
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!== true) { 
            // i.e. user is not logged in (loggedin session is false)
            echo '<li class="list-item-inline">
                    <a href="registration.php" class="link">Signup</a>
                </li>
                <li class="list-item-inline">
                    <a href="login.php" class="link">Login</a>
                </li>';
        } else {
            // user is logged in successfully
            echo '<li class="list-item-inline">
                    <a href="includes/logout.inc.php" class="link">Logout</a>
                </li>';
        }
        ?>
        </ul>
    </nav>

    <div style="margin-top: 10px;">
    <?php
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!== true) { 
        echo '<p>You are logged out! Press the Login button to login or Registerbutton to register...</p>';
    } else {
        echo '<h1>This is your profile page, '. $_SESSION["username"] .'</h1>';
    
    // profile image 
    $username = $_SESSION["username"];
    $sql = "SELECT * FROM user WHERE username='$username';";
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
                    echo "<img src='uploads/profile".$id.".jpg'>";
                } else {
                    echo "<img src='uploads/profiledefault.jpg'>";
                }
                echo $row['username'].'<br>';
                echo "</div>";
            }
        }
    }

    // username
    echo 'Username: '. $username .'<br>';

    // email
    $sqlEmail = "SELECT * FROM user WHERE username='$username';";
    $resultEmail = mysqli_query($conn, $sqlEmail);
    if(mysqli_num_rows($resultEmail)>0) {
        $rowEmail = mysqli_fetch_assoc($resultEmail);
        echo 'Email: '.$rowEmail['email'].'<br>';
    } else {
        echo "Row not found";
    }
    }
    ?>  
    </div>




</body>
</html>