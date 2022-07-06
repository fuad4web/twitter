<?php 
    $dsn = 'mysql:host=localhost; dbname=tweety';
    $user = 'root';
    $pass = '';

    try {
        $pdo = new PDO ($dsn, $user, $pass);
    } catch(PDOException $e) {
        echo 'Connection error! ' . $e->getMessage();
        echo '<script>alert("Database Connection Error");</script>';
    }
?>
