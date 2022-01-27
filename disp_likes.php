<?php
    include_once 'connect.php';
    session_start();
    if(!isset($_SESSION['user_n'])) {
        echo "<script>alert('Please log in to view likes.')</script>";
        echo "<script>window.location.href='home.php'</script>";
        exit();
    }

    $userN = $_SESSION['user_n'];

    $sql1 = "SELECT * FROM user_item_likes WHERE user = '$userN'";
    $result1 = mysqli_query($conn, $sql1);
    $resultcheck1 = mysqli_num_rows($result1);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Odin's Eye</title>
        <link href="Styles/main.css" rel="stylesheet"/>
    </head>
<body>
    <div class="top"">
        <img src="Img/logo_w_txt.PNG" height=125px width=125px alt=logo>
        <!-- <span id="title">Odin's Eye</span> -->
        <form action="search.php" method="POST" name="search" id="search" autocomplete="off">
            <input type="text" placeholder="Search..." name="query" id="query">
            <input type="submit" value="Search" name="btnsearch" id="btncsearch">
        </form>

        <?php if(!isset($_SESSION['user_n'])) { ?>
            <a href="login.php" id="btnlogin">Login</a> | 
            <a href="signup.php" id="btnsignup">Sign up</a>
        <?php } ?>

        <?php if(isset($_SESSION['user_n'])) { 
            echo "Welcome back, " . $_SESSION['user_n'] . "!";?>
            <button onclick="logout()">Logout</button>
        <?php } ?>

        <a href="home.php">Home</a>
    </div>
    <div class="likes">
        <ol>
        <?php
        if($resultcheck1 > 0) {
            while($row1 = mysqli_fetch_assoc($result1)) { 
                $itemname = $row1['item'];
                $sql2 = "SELECT * FROM items WHERE itemName = '$itemname'";
                $result2 = mysqli_query($conn, $sql2);
                $resultcheck2 = mysqli_num_rows($result2);
                if($resultcheck2 > 0) {
                    $row2 = mysqli_fetch_assoc($result2);
                    echo "<li><a href=\"" . $row2['itemLink'] . 
                    "\" target=_blank rel=noopener noreferrer>" . $row2['itemName'] . 
                    " (SGD" . ($row2['itemPrice']) . ")</a>
                    
                    <a class=\"likebtn\" href=\"like.php?name=" . $row2['itemName'] . "&price=" . $row2['itemPrice'] . "&link=" . $row2['itemLink'] 
                    . "\">&#10084;</a></li>";
                } 
            }
        } ?>
        </ol>
    </div>
    <script src="Scripts/logout.js"></script>
</body>

</html>