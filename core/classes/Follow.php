<?php 
    // this below code will get information from the User Class
    class Follow extends User{
        protected $pdo;

        function __construct($pdo) {
            $this->pdo = $pdo;
        }
    }
?>
