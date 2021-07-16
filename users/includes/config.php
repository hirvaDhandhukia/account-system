<!-- this file is to make a connection with database -->
<?php

    // database configuration using xampp
    define('DB_SERVER','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','account');

    // connecting to the database here
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // checking the connection 
    if($conn == false) {
        dir('error, something went wrong');
    }

?>