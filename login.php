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
		 
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>      
   </head>
   <div class="wrapper">
		 <div class="container-fluid">
   <body>
  	<div class="page-header">
                        <h2>Add Admin</h2>
                    </div>
               
               <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type="submit" class="btn btn-primary" value="Submit" />
								  <a href="index.php" class="btn btn-default">Cancel</a>
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</div>
</div>
</html>