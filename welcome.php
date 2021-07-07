<?php

session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserAccount | Techsevin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navigation container">
        <div class="nav-brand">
            <a href="indexx.html" class="nav-brand link">TECHSEVIN</a>
        </div>
        <ul class="list-non-bullet nav-pills">
            
            <?php

        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!== true) { 
            echo '<li class="list-item-inline">
            <a href="registration.php" class="link">Registration</a>
        </li>
        <li class="list-item-inline">
            <a href="login.php" class="link">Login</a>
        </li>';
        } else {
            echo '<li class="list-item-inline">
            <a href="logout.php" class="link">Logout</a>
        </li>
        <li class="list-item-inline">
        <a href="#" class="link user"><img class="img-icon" src="https://img.icons8.com/ios-glyphs/30/000000/user--v1.png"/></a>
        </li>';
        }
    ?>
        </ul>
    </nav>

    <div style="margin-top: 10px;">

    <?php

        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!== true) { 
            echo '<p>You are logged out! Press the Login button to login or Register button to register...</p>';
        } else {
            echo '<p>You are logged in successfully!</p>';
            echo 'Welcome '. $_SESSION["username"];
        }
    ?>
        
    </div>

</body>
</html>