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
    <title>Edit | Techsevin</title>
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
                    <a href="userinfo.php" class="link">Back-to-userinfo</a>
                </li>
                <li class="list-item-inline">
                    <a href="logout-admin.php" class="link">Logout</a>
                </li>';
        }
        ?>
        </ul>
    </nav>

    <!-- editing enabled here -->
    <div class="form-container">
    <h3 style="margin-bottom: 4px;">Edit the user's info here:</h3>
    <hr size="0">

    <form action="" method="post">
        <?php
            if(isset($_GET['username'])) {
                $username = $_GET['username'];
                echo '<div class="form-div col-flex12">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="username write" id="username" value="'.$username.'">
                    </div>';
            }
            if(isset($_GET['email'])) {
                $email = $_GET['email'];
                echo '<div class="form-div col-flex12">
                        <label class="form-label">E-mail</label>
                        <input type="text" name="email" class="email write" id="email" value="'.$email.'">
                    </div>';
            }
        ?>
        <div class="form-div">
            <button type="submit" name="submit" class="btn">Edit</button>
        </div>
    </form>
    </div>

    <?php
        if(isset($_GET["edit"])) {
            if($_GET["edit"] == "success") {
                echo '<p>Update Successful!</p>';
            }
        }
    ?> 
</body>
</html>


<?php
if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $sql = "UPDATE user SET username='$username',email='$email' WHERE id='$_SESSION[id]';";
    $request = mysqli_query($conn, $sql);
    if($request) {
        echo "Record Updated!";
        header("location: edit-userinfo.php?edit=success");
    } else {
        echo "Failed. Try again";
    }

}
?>