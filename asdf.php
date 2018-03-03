<html><head>Multi-button form</head>
<body>

<form method="post"> Enter a number: <input type="text" name="number[]" size="3"> <br> 
  <input type="text" name="number[]" size="3"> <br> 
<input type="submit" name="add" value="Submit"> 

</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
// check which button was clicked
// perform calculation
  $num = $_POST["number"];
for($i=0; $i<count($num); $i++)
  echo $num[$i]."<br/>";
}

?>
