<?php
    include_once 'connect.php';
    session_start();

    if(isset($_POST['btnlogin'])) {
        $custusername = ($_POST['txtusername']);
        $custpassword = ($_POST['txtpwd']);

        $sql = "SELECT * FROM user WHERE username = '$custusername' AND pwd = '$custpassword'";

        if ($result = mysqli_query($conn, $sql)) {
            $rows = mysqli_num_rows($result);
            if ($rows == 1) {
                $row = mysqli_fetch_row($result);
                $_SESSION['user_n'] = $row[0];
                header("Location: home.php");
                exit();
            } else {
                echo '<script>alert("Invalid Credentials. Please try again!");</script>';
                echo "<meta http-equiv='refresh' content='0'>";
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login Odin's Eye</title>
        
        <link href="Styles/login.css" rel="stylesheet"/>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
        crossorigin="anonymous"/>
    </head>
    
    <body>
        <div class="main">

            <img src="Img/logo.PNG" alt="logo" width=300px height=300px>

            <form action="#" method="POST" name="login" id="login" autocomplete="off">
                <div>
                    <input type="text" placeholder="Username" name="txtusername" id="txtusername" required><br>
                    <input type="password" placeholder="Password" name="txtpwd" id="txtpwd" required>
                    <img src="Img/showPwd.png" alt="Show password" width="20px" height="20px" onmouseover="toggleShow('txtpwd');" onmouseout="toggleHide('txtpwd');"/>
                </div>
                <input type="submit" value="Login" name="btnlogin" id="btnlogin">
            </form>
            <p>Don't have an account? Sign up <a href="signup.php">here</a>! Or</p>
            <p><a href="home.php">Browse as Guest!</a></p>

            <script src="Scripts/togglePwd.js"></script>
        </div>
    </body>
</html>