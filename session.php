<?php
   include('config.php');
//session is started
   session_start();
//variable stores the session variable login_user
    $user_check = $_SESSION['login_user'];
//checks if the user is an admin from the admin table
      $sql = "select username from admin where username = '$user_check'";
      $stmt = $pdo->prepare($sql);
      $result = $stmt->execute();
      $row= $stmt->fetch(PDO::FETCH_ASSOC);
      $login_session = $row['username'];
//if this variable is not set, redirect user to login.php
   if(!isset($_SESSION['login_user'])){
      header("location: login.php");
   }
?>