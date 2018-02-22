<?php
   include('config.php');
   session_start();
    $user_check = $_SESSION['login_user'];

      $sql = "select username from admin where username = '$user_check'";
      $stmt = $pdo->prepare($sql);
      $result = $stmt->execute();
      $row= $stmt->fetch(PDO::FETCH_ASSOC);
      $login_session = $row['username'];

   if(!isset($_SESSION['login_user'])){
      header("location: login.php");
   }
?>