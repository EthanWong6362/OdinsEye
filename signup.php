<?php
    include_once 'connect.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up Odin's Eye</title>
    <link href="../Styles/login.css" rel="stylesheet"/>
</head>
<body>
    <img src="Img/logo_w_txt.PNG" alt="logo" width=150px height=150px>

    <form action="insertacc.php" method="POST" name="login" id="login" autocomplete="off">
        <div>
            <input type="text" placeholder="Username" name="txtusername" id="txtusername" required><br>
            <input type="password" placeholder="Password" name="txtpwd" id="txtpwd" required>
            <img src="Img/showPwd.png" alt="Show password" width="20px" height="20px" onmouseover="toggleShow('txtpwd');" onmouseout="toggleHide('txtpwd');"/><br>
            <input type="password" placeholder="Confirm password" name="retxtpwd" id="retxtpwd" required>
            <img src="Img/showPwd.png" alt="Show password" width="20px" height="20px" onmouseover="toggleShow('retxtpwd');" onmouseout="toggleHide('retxtpwd');"/>
        </div>
        <input type="submit" value="Create Account" name="btncreate" id="btncreate">
    </form>
    <p>Already have an account? Log in <a href="login.php">here</a>! Or</p>
    <p><a href="home.php">Browse as Guest!</a></p>

    <script src="Scripts/togglePwd.js"></script>
</body>
</html>