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
          $sql = "SELECT Tenant_Id FROM useraccount WHERE id=?";
          if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("i", $romnumber);
              $romnumber = $_POST['userpaymententID'];
              $stmt->execute();
      
              $result = $stmt->get_result();
              $roomEditResult = $result->fetch_assoc();
              $occupants_errcheck = $roomEditResult['Tenant_Id'];
              $stmt->close();
            }
          $sql2 = "SELECT Tenant_Name, location, roomnumber FROM tenant WHERE Tenant_Id=?";
          if($stmt = $mysqli->prepare($sql2)){
            $stmt->bind_param("i", $romnumber1);
              $romnumber1 = $occupants_errcheck;
              $stmt->execute();
      
              $result = $stmt->get_result();
              $EditResult = $result->fetch_assoc();
              $name123 = $EditResult['Tenant_Name'];
              $location = $EditResult['location'];
              $roomnumbers = $EditResult['roomnumber'];
              $stmt->close();
            }
          $sqlsssss = "INSERT INTO userpayment1 (tenantname, location, roomnumber, remark, tracking, Tenant_ID, status, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  
          if($stmt = $mysqli->prepare($sqlsssss)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("ssississ", $tenantname, $location1, $roomnumber1, $remark, $tracking, $id, $status, $date);
              $tenantname = $name123;
              $location1 = $location;
              $roomnumber1 = $roomnumbers;
              $remark = $_POST['remark'];
              $tracking = $_POST['trackingnumber'];
              $id = $occupants_errcheck;
              $status ="Pending";
              $date = $_POST['date'];
              // Set parameters
             
              
              if($stmt->execute()){
                  // Redirect to login page
                  header("location: userpayment.php");
              } else{
                $errormsg = "sorry there was a error";
                echo "<script>alert('$errormsg');
                location='tenantmanagement.php';
                </script> ";
                 header("location: userpayment.php");
              }
  
  
                $stmt->close();
  
          }
    $mysqli->close();
  
    }
  // Close connection
}



?>

