<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Techsevin</title>
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
                <a href="#" class="link active">Login</a>
            </li>
            <li class="list-item-inline">
                <a href="logout.php" class="link">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- login form here -->
    <div class="form-container">
    <h3 style="margin-bottom: 4px;">Login Here:</h3>
    <hr size="0">

    <form action="" method="post">
        <div class="form-div col-flex12">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="username write" id="username" placeholder="Username">
        </div>
        <div class="form-div col-flex12">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="password write" id="password" placeholder="Password">
        </div>

        <div class="form-div">
            <button type="submit" class="btn">Login</button>
        </div>

    </form>
    </div>

</body>
</html>