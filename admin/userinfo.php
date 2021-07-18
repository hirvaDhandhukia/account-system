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
    <title>User-Info | Techsevin</title>
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
            echo '<li class="list-item-inline">
                    <a href="index-admin.php" class="link">Home</a>
                </li>
                <li class="list-item-inline">
                    <a href="logout-admin.php" class="link">Logout</a>
                </li>';
        }
        ?>
        </ul>
    </nav>

    <h1>All User's Information will be shown here:</h1>

    <?php
        $sql = "SELECT * FROM user;";

        // querying the sql stetement here
        $result = mysqli_query($conn, $sql);

        // to check if the selected info has any number of rows or not
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                // echo $row['id'] . "<br>";
                // echo $row['username'] . "<br>";
                // echo $row['email'] . "<br>";
                // echo $row['created_at'] . "<br>";
                print_r($row);
            }
        }
    ?>

</body>
</html>