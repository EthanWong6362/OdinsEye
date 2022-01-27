<?php
    session_start();            

    session_destroy();

    echo "<script>alert('You have successfully logged out!')</script>";

    echo "<script>window.location.href='pages/home.php'</script>"
?>