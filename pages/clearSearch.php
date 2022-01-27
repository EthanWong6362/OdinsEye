<?php
    session_start();

    unset($_SESSION['q']);
    header("Location: home.php");
?>