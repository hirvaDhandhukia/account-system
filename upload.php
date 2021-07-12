<?php

session_start();
include_once 'config.php';
$id = $_SESSION['id'];

// this script will fetch the image or file from a form and then upload it to my storage file
if(isset($_POST['submitImg'])) {

    // in order to upload the file, we need to get info of the file
    // $_FILES gives the info from the file that we want to upload using an input in a form
    $file = $_FILES['file'];

    // print_r($file);
    // below is all the infomation of the file
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // grabbing the file extension
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    // check if value of $fileActualExt is inside the array $allowed or not
    if(in_array($fileActualExt, $allowed)) {
        if($fileError === 0) {
            if($fileSize < 1000000) {
                $fileNameNew = "profile".$id.".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                $sql = "UPDATE profileimg SET status=0 WHERE userid='$id';";
                $result = mysqli_query($conn, $sql);

                header("location: welcome.php?uploadsuccess");
            } else {
                echo "your file is too big";
            }
        } else {
            echo "there was an error during uploading ur file";
        }

    } else {
        echo "you cannot upload files of this type. upload only jpg, jpeg, png or pdf type";
    }


} else {
    echo "Submit button is not clicked yet.";
}
