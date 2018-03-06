<?php
// Include config file
require_once 'config.php';
 session_start(); // commence session
// Define variables and initialize with empty values
$username = $password  = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    $input_username = trim($_POST["username"]); //form input "username" stored as input_name
    if(empty($input_username)){
        $username_err = "Please enter a username."; //blank usernames are not valid
    } elseif(!filter_var(trim($_POST["username"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $username_err = 'Please enter a valid username.'; //usernames with special characters are not valid
    } else{
        $username = $input_username; // if validated it is stored as username
    }
    
    // Validate password
    $input_password = trim($_POST["password"]); //trim the password
    if(empty($input_password)){
        $password_err = 'Please enter a password.';      //no empty passwords allowed
    } else{
        $password = $input_password;
    }

 
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO admin (username, password) VALUES (:username, :password)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username);
            $stmt->bindParam(':password', $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = $password;
;            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to login page
                $_SESSION['login_user'] = $username;
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);

}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Admin</title>
    <link rel="stylesheet" href="loginStyle.css"> <!-- CSS file reference-->

</head>
<body>
    <div class="login-page">
        <div class="container-fluid">
                    <div class="form">
                        <h2>Create Admin</h2>
                    <p>Please fill this form and submit to add an administrator to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="on" class="login-form">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <input type="text" name="username" placeholder="username" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <input type="password" name="password" placeholder="password" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" value="Submit" id="submit">
                        <a href="login.php">Cancel</a>
                    </form>
          </div>
        </div>
    </div>
</body>
</html>