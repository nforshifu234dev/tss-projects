<?php 

    require_once 'assets/php/config.php';

    session_destroy();

    unsetAnArrayItem($_SESSION['userSSID']);
    unsetAnArrayItem($_SESSION['userSSIDToken']);
    unsetAnArrayItem($_SESSION['isLoggedIn']);

    header("location: index.php?logout=success");

?>