<?php
// Include the ShoppingCart class.  Since the session contains a
// ShoppingCard object, this must be done before session_start().
require "../model/cart.php";
session_start();
require '../model/dbconnect.php';
$connection = connect_to_db("COOP");
require '../model/queries.php';
?>

<!DOCTYPE html>


<?php
// If this session is just beginning, store an empty ShoppingCart in it.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = new ShoppingCart();
}

// for security php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
// variables to hold error messages
$nameErr = $emailErr = $numberErr = $buildingErr = $roomErr = "";

// variables to hold
$finalCheck = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // firstname validation
  $nameResult = $_POST["name"];
  if (empty($nameResult)) {
    $nameErr = "Name is required";
    $finalCheck = "false";
  } else if (!preg_match ("/^[a-z ,.'-]+$/i", $nameResult)){
    $finalCheck = "false";
    $nameErr = "Must contain only letters!";
  }


  // email validation
  $emailResult = $_POST["email"];
  if (empty($emailResult)) {
    $emailErr = "Email is required";
    $finalCheck = "false";
  } else if (!preg_match ("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $emailResult)){
    $finalCheck = "false";
    $emailErr = "Enter a valid email!";
  }


  // number validation
  $numberResult = $_POST["number"];
  if (empty($numberResult)) {
    $numberErr = "Student ID number is required";
    $finalCheck = "false";
  } else if (!preg_match ("/^[0-9]{9}$/", $numberResult)){
    $finalCheck = "false";
    $numberErr = "Must be a 9 digit number";
  }


  // building validation
  $buildingResult = $_POST["building"];
  if (empty($buildingResult)) {
    $buildingErr = "Building is required";
    $finalCheck = "false";
  } else if (!preg_match ("/^[a-zA-Z\s]+$/", $buildingResult)){
    $finalCheck = "false";
    $buildingErr = "Must be letters only!";
  }

  // zipcode validation
  $roomResult = $_POST["room"];
  if (empty($roomResult)){
    $roomErr = "Room is required";
    $finalCheck = "false";
  } else if (!preg_match ("/^[0-9]+$/",$roomResult)) {
    $finalCheck = "false";
    $roomErr = "Room must contain only numbers!";
  }
}

  ?>
<!-- HTML CODEE!!!! -->
<html lang="en">

<head>
  <title>Checkout</title>
  <style>
    .error {color: #FF0000;}
  </style>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <!-- jQuery  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <!-- SCRIPT FOR AUTOCOMPLETE IN JQUERY WITH OWN STYLE -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />


</head>

<body>


<h2 id="checkout" class="w3-container w3-blue">Checkout</h2>



<form method="post" id="info" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<!--ALL FORMS  -->
<h3>Your Information: </h3>
<legend for = "name"> Name: <input value="<?php echo $nameResult;?>" id = "name" type="text" name="name">
    <span class="info">* <?php echo $nameErr;?></span>
<br><br>
</legend>


<legend for = "email"> Email:
    <input id = "email" value="<?php echo $emailResult;?>" type="text" name="email">
    <span class="info">* <?php echo $emailErr;?></span>
<br><br>
</legend>

<legend for = "studentId"> Student ID Number:
    <input id = "number" value="<?php echo $numberResult;?>" type="text" name="number">
    <span class="info">* <?php echo $numberErr;?></span>
<br><br>
</legend>


<legend for = "building"> Dorm Building: <input id = "building" value="<?php echo $buildingResult;?>" type="text" name="building">
    <span class="info">* <?php echo $buildingErr;?></span>
<br><br>
</legend>

<legend for = "room"> Room Number: <input id = "room" type="text" value="<?php echo $roomResult;?>" name="room">
    <span class="info">* <?php echo $roomErr;?></span>
<br><br>
</legend>


    <input class="w3-btn w3-hover-grey w3-orange" type="submit" name="submit" value="Submit" >

<p> * = required field </p>

<h3 class="w3-container w3-blue"> Here is your order:</h3>

</form>

 <table id="order" class="w3-table w3-striped w3-border">
          <tr> <th>Food Item</th> <th>Quantity</th> <th>Price</th></tr> 
 
          <?php 
          
          foreach($_SESSION['cart']->getOrder() as $variety=>$quantity) {
              $p = ShoppingCart::$prices[$variety];
              $price = $p * doubleval($quantity);
              $fooditem = ShoppingCart::$foodTypes[$variety];
              echo "<tr>
                <td>$fooditem</td>
                <td>$quantity</td>
                <td>$$price</td>
                </tr>";
           }

           
           ?>
      </table>


</body>
</html>

<?php

  if ($finalCheck == "" && $_POST["number"]){
    echo "<br>  <div class=\"w3-xlarge\" >Name: $nameResult <br> Email: $emailResult <br> Student ID:  $numberResult <br> Building:  $buildingResult <br> Room Number:  $roomResult <br>" ;
    echo "ORDER SUCCESSFUL! You will be recieving a confirmation email at $emailResult </div><br>";



  	mysqli_stmt_execute($selectCustomer);
  	$selectCustomer -> bind_result($cid);


  	if($selectCustomer -> fetch()) { //check if customer is already in database
  	} else { // insert customer id
  		mysqli_stmt_execute($insertCustomer);
  		print_r($connection->error);
  		$cid = mysqli_stmt_insert_id($insertCustomer);
      mysqli_stmt_close($insertCustomer);
  	}

      mysqli_stmt_close($selectCustomer);


      mysqli_stmt_execute($insertPurchaseOrder);
  		print_r($connection->error);
  		$pid = mysqli_stmt_insert_id($insertPurchaseOrder);
      mysqli_stmt_close($insertPurchaseOrder);



    foreach ($_SESSION['cart']->getOrder() as $variety => $quantity) {
      $p = ShoppingCart::$prices[$variety];
      $cost = $p * doubleval($quantity);
      $fooditem = ShoppingCart::$foodTypes[$variety];
      mysqli_stmt_execute($insertFood);
      print_r($connection->error);
    }
    mysqli_stmt_close($insertFood);

    session_unset();  // remove all session variables
    session_destroy();
    echo "<br><br><br><p><center><button class=\"w3-btn w3-large w3-hover-grey w3-orange\" href=\"../../index.php\">Place another order!</button></center></p>";

    echo "<script>
      document.getElementById('order').style.display='none';
      document.getElementById('info').style.display='none';
      document.getElementById('checkout').innerHTML='Order Confirmed';

    </script>";
      
    // email system

    $destinationEmail = $emailResult;
    $fromEmail = "cooponlineinfo@gmail.com";
    $message = "Thank you for your purchase! Your estimated time remaining is...";

    // require the library for STMP email server
    require("PHPMailerAutoload.php");

    $mail = new PHPMailer();

    $mail->IsSMTP();

    // server host
    $mail->Host = "smtp.gmail.com";
      
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    $mail->SMTPAuth = true;

    $mail->Username = "cooponlineinfo@gmail.com";
    $mail->Password = "Coop123!";

    $mail->From = $fromEmail;
    $mail->AddAddress($destinationEmail, "Customer number...");

    // set word wrap to 50 characters
    $mail->WordWrap = 50;
    // set email format to HTML
    $mail->IsHTML(true);

    $mail->Subject = "Confirmation number....!";

    $mail->Body    = $message;
    $mail->AltBody = $message;

    if(!$mail->Send()){
      echo "Message could not be sent.";
      echo "Mailer Error: " . $mail->ErrorInfo;
      exit;
    }

    echo "Message has been sent";  
      
}
?>

