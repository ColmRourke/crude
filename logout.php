<?php
//when user logs-out the session is destroyed and user is directed to the login page
   session_start();
   
   if(session_destroy()) {
      header("Location: login.php");
   }
?>