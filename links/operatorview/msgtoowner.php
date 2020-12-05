<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$name123 ="";
$occupantsedit1 = 0;
$occupants=0;
$occupants_errcheck = 0;
$occupantedit =0;
$occupant_err="";
$roomnumbers = 0;
$location = 0;
$wow = "";
$image ="";
$errormsg = "";

//$TenantIDEDIT
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['adduserpayment']))
    {
          $sqlsssss = "INSERT INTO tenan_message (tenant_name, location, roomnumber, tenant_id, message, date) VALUES (?, ?, ?, ?, ?, ?)";
  
          if($stmt = $mysqli->prepare($sqlsssss)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("ssiiss", $tenantname, $location1, $roomnumber1, $id, $msg, $date);
              $tenantname = $_POST['tenantname'];
              $location1 = "operator";
              $roomnumber1 = "operator";
              $id = 99;
              $msg = $_POST['message'];
              $date = $_POST['date'];
              // Set parameters
             
              
              if($stmt->execute()){
                  // Redirect to login page
                  header("location: ownermsg.php");
              } else{
                $errormsg = "sorry there was a error";
                echo "<script>alert('$errormsg');
                location='tenantmanagement.php';
                </script> ";
                header("location: ownermsg.php");
              }
  
  
                $stmt->close();
  
          }
    $mysqli->close();
  
    }
  // Close connection
}



?>

