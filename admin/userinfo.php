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
        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!== true) {
            echo "You are not logged in! Please, login and try again later";
        } 
        else {
    ?>

    <div class="table-userinfo">
    <table>
        <thead>
            <th>Id</th>
            <th>Username</th>
            <th>E-mail</th>
            <th>Profile-Img</th>
        </thead>
        <tbody>

        <?php
       $sql = "SELECT * FROM user;";

        // querying the sql stetement here
        $result = mysqli_query($conn, $sql);

        // to check if the selected info has any number of rows or not
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                // print_r($row);
        ?>
                <tr>
                    <td><?php echo $row['id'] . "<br>"; ?></td>
                    <td><?php echo $row['username'] . "<br>"; ?></td>
                    <td><?php echo $row['email'] . "<br>"; ?></td>
                    <td><?php 
                    $username = $row['username'];
                    $sqlImg = "SELECT * FROM user WHERE username='$username';";
                    $resultImg = mysqli_query($conn, $sqlImg);
                    if(mysqli_num_rows($resultImg) > 0) {
                        while($rowImg = mysqli_fetch_assoc($resultImg)) {
                            // we want to get the id of user who is loggedin inside the user table. $id ke andar    user-table ke id ki info store karwa di. 
                            $id = $rowImg['id'];
                            $sqlImgg = "SELECT * FROM profileimg WHERE userid='$id';";
                            $resultImgg = mysqli_query($conn, $sqlImgg);
                            while($rowImgg = mysqli_fetch_assoc($resultImgg)) {
                                echo "<div class='user-container'>";
                                if($rowImgg['status'] == 0) {
                                    echo "<img src='../uploads/users/profile".$id.".jpg'>";
                                } else {
                                    echo "<img src='../uploads/profiledefault.jpg'>";
                                }
                                echo "</div>";
                            }
                        }
                    } ?></td>
                </tr>
        <?php
        }
    }
}
    ?>

        </tbody>
    </table>
</div>

</body>
</html>