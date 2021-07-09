<?php

session_start(); 
require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserAccount | Techsevin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .sidepanel {
            width: 0;
            position: fixed;
            z-index: 1;
            height: 250px;
            top: 0;
            right: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            opacity: 75%;
        }
        .sidepanel a {
            padding: 8px 32px 8px 8px;
            text-decoration: none;
            /* font-size: 25px; */
            color: #818181;
            display: block;
            transition: 0.3s;
        }
        .sidepanel a:hover {
            color: #f1f1f1;
        }
        .sidepanel .closebtn {
            position: absolute;
            top: 0;
            left: 8px;
            font-size: 36px;
        }
        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: rgb(214, 214, 214);
            color: white;
            padding: 6px 12px;
            border: none;
        }
        .openbtn:hover {
            background-color:#444;
        }
    </style>
</head>
<body>
<nav class="navigation container">
        <div class="nav-brand">
            <a href="#" class="nav-brand link">TECHSEVIN</a>
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
                    <div id="sidePanel" class="sidepanel">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                        <a href="#">image</a>
                    </div> 
                    <button class="openbtn" onclick="openNav()"><img class="img-icon" src="https://img.icons8.com/ios-glyphs/30/000000/user--v1.png"/></button>
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
            echo '<h1>Welcome '. $_SESSION["username"] .'</h1>';
            
    $sql = "SELECT * FROM user";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // we want to get the id of user who is loggedin inside the user table
            // $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
            $sqlImg = "SELECT * FROM profileimg WHERE userid='$id'";
            $resultImg = mysqli_query($conn, $sqlImg);
            while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                // $rowImg = mysqli_fetch_assoc($resultImg);
                echo "<div>";
                if($rowImg['status'] == 0) {
                    echo "<img src='uploads/profile".$id.".jpg'>";
                } else {
                    echo "<img src='uploads/profiledefault.jpg'>";
                }
                echo $row['username'];
                echo "</div>";
            }
        }
    }
            echo "<form action='upload.php' method='post' enctype='multipart/form-data'>
            <input type = 'file' name='file'>
            <button type='submit' name='submitImg'>UPLOAD</button>
            </form>";
        }
    ?>
        
    </div>

    <script>
        function openNav() {
            document.getElementById("sidePanel").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("sidePanel").style.width = "0";
        }
    </script>
</body>
</html>