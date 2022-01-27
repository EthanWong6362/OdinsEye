<?php
$custname = $_POST['txtusername'];
$custpwd = $_POST['txtpwd'];
$repwd = $_POST['retxtpwd'];

include_once 'connect.php';

if ($custpwd != $repwd) {
    die("<script>alert('Passwords do not match, please try again'); window.history.go(-1);</script>");
}

$check_username = "SELECT * FROM user WHERE username = '$custname'";
$result = mysqli_query($conn, $check_username);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);

    if($custname == isset($row['username'])){
        die("<script>alert('Username has been taken, please re-enter your username'); window.history.go(-1);</script>");
    }
} else {
    $insert_customer = "INSERT INTO user (username, pwd) VALUE ('$custname', '$custpwd')";

    mysqli_query($conn, $insert_customer);
            
    if(mysqli_affected_rows($conn) <= 0) {
            //USERNAME IS THE PRIMARY KEY, THUS NO DUPICATION WILL BE HAPPENING
            die("<script>alert('Username has been taken, please re-enter your username'); window.history.go(-1);</script>");
    } 
    else {
            echo"<script>alert('Your Account has been created successfully');</script>";
            echo"<script>location.href='login.php'</script>";
    }
}
?>