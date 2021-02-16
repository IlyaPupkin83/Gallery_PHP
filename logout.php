<?php   
    session_start();
    session_destroy();
    unset($_SESSION['username']);
    $_SESSION['message'] = 'Вы вышли из профиля';
    header("location: login.php");
