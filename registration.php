<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Techsevin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navigation container">
        <div class="nav-brand">
            <a href="#" class="nav-brand link">TECHSEVIN</a>
        </div>
        <ul class="list-non-bullet nav-pills">
            <li class="list-item-inline">
                <a href="#" class="link active">Registration</a>
            </li>
            <li class="list-item-inline">
                <a href="login.php" class="link">Login</a>
            </li>
            <li class="list-item-inline">
                <a href="logout.php" class="link">Logout</a>
            </li>
        </ul>
    </nav>


    <!-- registration form -->
    <div class="form-container">

    <form action="" method="post">
        <div class="form-div col-flex6">
            <label class="form-label">First Name</label>
            <input type="text" name="fname" class="fname write" id="fname" placeholder="First Name">
        </div>
        <div class="form-div col-flex6">
            <label class="form-label">Last Name</label>
            <input type="text" name="lname" class="lname write" id="lname" placeholder="Last Name">
        </div>
        <div class="form-div col-flex12">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="username write" id="username" placeholder="Username">
        </div>
        <div class="form-div col-flex12">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="email write" id="email" placeholder="name@example.com">
        </div>

        <div class="form-div col-flex12">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="address write" id="address" placeholder="Address">
        </div class="inline">

        <div class="form-div col-flex6">
            <label class="form-label">City</label>
            <select name="city" id="city" class="write">
                <option selected></option>
                <option value="1">Ahmedabad</option>
                <option value="2">Mumbai</option>
                <option value="3">Delhi</option>
                <option value="4">Bangalore</option>
                <option value="4">Udaipur</option>
            </select>
        </div>
        <div class="form-div col-flex6">
            <label class="form-label" for="date">Birth Date</label>
            <input type="date" name="date" id="date" class="write">
        </div>

        <div class="form-div col-flex12">
            <label class="form-label">Gender</label>
            <div class="form-div-gender">
                <input type="radio" name="male" id="male" class="radio-inp">
                <label for="male">Male</label>
                <input type="radio" name="female" id="female"   class="radio-inp">
                <label for="female">Female</label>
                <input type="radio" name="other" id="other"     class="radio-inp">
                <label for="other">Other</label>
            </div>
        </div>

        
        <div class="form-div col-flex6">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="password write" id="password" placeholder="Password">
        </div>
        <div class="form-div col-flex6">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="cpassword" class="cpassword write" id="cpassword" placeholder="Confirm Password">
        </div>


        <div class="form-div col-flex12">
            <label for="box"><input type="checkbox" name="box" id="box"> Create my account</label>
        </div>
        <div class="form-div">
            <button type="submit" class="btn">Sign in</button>
        </div>
    </form>
    </div>

</body>
</html>