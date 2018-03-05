<?php

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$dbname = 'crude';
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'crude');
define('DB_PASSWORD', '0000');
define('DB_NAME', $dbname);
/* Attempt to connect to MySQL database */
try{

      $pdo = new PDO("mysql:host=" . DB_SERVER, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    
    $pdo->exec ("CREATE DATABASE IF NOT EXISTS $dbname");
    //use exec() because no results are returned
    $pdo->exec("use $dbname");
    $sql = "CREATE TABLE IF NOT EXISTS employees (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    salary INT(10) NOT NULL,
    email VARCHAR(100) NOT NULL
    )";
    $pdo->exec($sql);
    $sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sql);

  }
  catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
  }
?>