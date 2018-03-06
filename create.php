<?php
// Include config file
require_once 'config.php';
// Define variables and initialize with empty values
$name = $address = $salary = $email = "";
//$name_err = $address_err = $salary_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate names

   //declare array variables to store the inputs
   $array_name = ($_POST["name"]);
   $array_address = ($_POST["address"]);
   $array_salary= ($_POST["salary"]);
   $array_email = ($_POST["email"]);
  
  //for each variable in each array, check validitiy and submit them to database
  for($i = 0; $i < count($array_name); $i++){
    $input_name = trim($array_name[$i]); //store the name and trim at index i
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($input_name), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name; // if validated it is stored as name
    }
    
    // Validate address
    $input_address = trim($array_address[$i]); //store variable at i position
    if(empty($input_address)){
        $address_err = 'Please enter an address.';     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($array_salary[$i]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = 'Please enter a positive integer value.';
    } else{
        $salary = $input_salary;
    }
  
  // Validate email
    $input_email = ($array_email[$i]);
    if(empty($input_email)){
        $email_err = "Please enter your email.";     
    } elseif(!filter_var($input_email,FILTER_VALIDATE_EMAIL)){
        $email_err = 'Please enter a correct email details.';
    } else{
        $email = $input_email;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err) && empty($email_err)){
              //send email
      ini_set( 'display_errors', 1 );
      error_reporting( E_ALL ); //speciies which errors have been reported
      $admin_email = $email; //sends to the employees address
      $subject = 'CodeAnwhere: New employee added';
      $comment = 'New employee added: ' . $name;  //message sent to new empoloyee
      $Headers = "From: rourkecolm@gmail.com \r\n" . 
      "Content-type: text/html; charset=UTF-8 \r\n"; 
      mail($admin_email, $subject, $comment, $Headers); //php function that sends an email notification
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary, email) VALUES (:name, :address, :salary, :email)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':address', $param_address);
            $stmt->bindParam(':salary', $param_salary);
            $stmt->bindParam(':email', $param_email);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_email = $email;
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }      
        // Close statement
        unset($stmt);
    }
  }
    header("location: index.php"); //direct user to index.php (dashboard)
    exit();
    // Close connection
    unset($pdo);

}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        .form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);       
}
      body {
  background: #76b852; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  background: -moz-linear-gradient(right, #76b852, #8DC26F);
  background: -o-linear-gradient(right, #76b852, #8DC26F);
  background: linear-gradient(to left, #76b852, #8DC26F);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
       
}
      .wrapper{
            width: 750px;
            margin: 0 auto;
        }
      #submit {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4CAF50;
  width: 43%; 
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                   
                 
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="on">
                     <div id="Questions">
                         <div class="form">
                           <p>Please fill this form and submit to add employee record to the database.</p>
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name[]"  class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address[]" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary[]" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                      <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="email[]" class="form-control" value="<?php echo $email; ?>"> <!--note changes here of the name, it is now an array -->
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                         </div>
                      </div>
                     </div>                
                        <input type="submit" value="Submit" id="submit">
                        <a href="index.php"id="submit">Cancel</a>
                    </form>     
              <button id="submit" class="btn btn-default" onclick="duplicate()">Add another employee</button> <!--User can add multiple employees -->
                </div>
            </div>        
        </div>
  </div>
  <script>   //clones the questions in the form so another employee can be added. 
    var i = 0;
    var original = document.getElementById("Questions"); // original is now the div with id "Questions"

function duplicate() {  
    var clone = original.cloneNode(true); // "deep" clone
    clone.id = "Questions" + ++i;
    original.parentNode.appendChild(clone);  //append the clone to original
}
  </script>
</body>
</html>