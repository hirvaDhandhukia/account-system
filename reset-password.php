
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
                <a href="logout.php" class="link">Logout</a>
            </li>
        </ul>
    </nav>


    <div class="form-container">
    <h3 style="margin-bottom: 4px;">Reset your password:</h3>
    <hr size="0">

    <form action="reset-request.inc.php" method="post">
        <div class="form-div col-flex12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="email write" id="email" placeholder="Enter your email address">
            <small>An e-mail will be send to you with the instructions on how to reset your password.</small>
        </div>

        <div class="form-div">
            <button type="submit" name="reset-request-submit" class="btn">Send Mail</button>
        </div>

    </form>
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