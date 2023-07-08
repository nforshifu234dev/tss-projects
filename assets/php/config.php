<?php

    // Include the db.php file
    require_once 'db.php';
    require_once 'functions.php';

    // Database configuration
    $config = array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'user' => 'id21013465_nforshifu_234',
        'password' => '@EstherOkafor123',
        'dbName' => 'id21013465_tss_db'
    );

    // Establish a database connection
    $pdo = connectDB($config);

    // start session
    session_start();


?>