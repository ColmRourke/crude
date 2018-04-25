<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername =$_POST['username'];
      $mypassword = $_POST['password']; 
      
      $sql = "SELECT id FROM admin WHERE username = '$myusername' and password = '$mypassword'";
      $stmt = $pdo->prepare($sql);
      $result = $stmt->execute();
      $row= $stmt->fetch(PDO::FETCH_ASSOC);
      $active = $row['active'];
      $count = $stmt->rowCount();
     
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
        // session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         header("location: index.php");
      }else {
         $error = "Your Login Name or Password is invalid" . $count;
      }
   }
?>
<html>
   
   <head>
      <title>Login Page</title>
		  <link rel="stylesheet" href="loginStyle.css">    
   </head>
   <div class="login-page">
		 <div class="container-fluid">
   <body>
  	<div class="form">
                        <h2>Login</h2>
                   
                
               <form action = "" method = "post" class="login-form">
                  <input type = "text" placeholder="username" name = "username" class = "box"/><br /><br />
                  <input type = "password" name = "password" placeholder="password" class = "box" /><br/><br />
                  <input type="submit" class="btn btn-primary" value="Login" id="submit"/>
								  <a href="indexWithoutlogin.php" class="btn btn-default">Cancel</a>
								  <a href="addAdmin.php" class="btn btn-default">Add administrator</a>
               </form>
               
              
					
            </div>
				
         </div>
			
      </div>
</div>
   </body>
</div>
</div>
</html>