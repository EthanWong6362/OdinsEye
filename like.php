<?php
    include_once 'connect.php';
    session_start();
    if (!isset($_SESSION['user_n'])) {
        echo "<script>alert('Please log in to like this item.')</script>";
        echo "<script>window.history.go(-1)</script>";
    } else {
        $USER = $_SESSION['user_n'];            
        $NAME = $_GET['name'];
        $PRICE = (float)$_GET['price'];
        $LINK = $_GET['link'];
        $str = $USER . $NAME;
        $USER_ITEM = hash('ripemd160', $str);

        $check_if_liked = "SELECT * FROM user_item_likes WHERE user_item = '$USER_ITEM'";
        $result = mysqli_query($conn, $check_if_liked);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
    
            if($USER_ITEM == isset($row['user_item'])){
                // already liked, so we unlike it
                $unlikesql = "DELETE FROM user_item_likes WHERE user_item = '$USER_ITEM'";
                $action = mysqli_query($conn, $unlikesql);
                if($action){
                    echo "<script>alert('Item removed from Likes list.')</script>";
                    echo "<script>window.history.go(-1)</script>";
                } else{
                    echo "<script>alert('Action unsuccessful.')</script>";
                    echo "<script>window.history.go(-1)</script>";
                }
            }
        } else {
            $check_item = "SELECT * FROM items WHERE itemName = '$NAME'";
            $item_result = mysqli_query($conn, $check_item);

            if(mysqli_num_rows($item_result) > 0) {
                $item_row = mysqli_fetch_assoc($item_result);

                if($NAME == isset($item_row['itemName'])) {
                    //item data exists, so like directly
                    $insert_like = "INSERT INTO user_item_likes (user, item, user_item) VALUE ('$USER', '$NAME', '$USER_ITEM')";
                    mysqli_query($conn, $insert_like);
                    echo "<script>alert('You have liked this item!')</script>";
                    echo "<script>window.history.go(-1)</script>";
                }
            } else {
                //insert item first
                $insert_item = "INSERT INTO items (itemName, itemPrice, itemLink) VALUE ('$NAME', '$PRICE', '$LINK')";
                mysqli_query($conn, $insert_item);

                $insert_like = "INSERT INTO user_item_likes (user, item, user_item) VALUE ('$USER', '$NAME', '$USER_ITEM')";
                mysqli_query($conn, $insert_like);

                if(mysqli_affected_rows($conn) <= 0) {
                    //already liked, so we unlike
                    $unlikesql = "DELETE FROM user_item_likes WHERE user_item = '$USER_ITEM'";
                    $action = mysqli_query($conn, $unlikesql);
                    if($action){
                        echo "<script>alert('Item removed from Likes list.')</script>";
                        echo "<script>window.history.go(-1)</script>";
                    } else{
                        echo "<script>alert('Action unsuccessful.')</script>";
                        echo "<script>window.history.go(-1)</script>";
                    }
                } 
                else {
                    echo "<script>alert('You have liked this item!')</script>";
                    echo "<script>window.history.go(-1)</script>";
                }
            }
        }
    }
?>