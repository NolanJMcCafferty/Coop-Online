<?php
// Include the ShoppingCart class.  Since the session contains a
// ShoppingCard object, this must be done before session_start().
require "../model/cart.php";
session_start();
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
$finalCheck = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // firstname validation
  $nameResult = $_POST["name"];
  if (empty($nameResult)) {
    $nameErr = "Name is required";
    $finalCheck = false;
  } else if (!preg_match ("/^[a-z ,.'-]+$/i", $nameResult)){
    $finalCheck = false;
    $nameErr = "Must contain only letters!";
  } else {
    $finalCheck = true;
  }


  // email validation
  $emailResult = $_POST["email"];
  if (empty($emailResult)) {
    $emailErr = "Email is required";
    $finalCheck = false;
  } else if (!preg_match ("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $emailResult)){
    $finalCheck = false;
    $emailErr = "Enter a valid email!";
  } else {
    $finalCheck = true;
  }


  // number validation
  $numberResult = $_POST["number"];
  if (empty($numberResult)) {
    $numberErr = "Student ID number is required";
    $finalCheck = false;
  } else if (!preg_match ("/d{9}/", $numberResult)){
    $finalCheck = false;
    $numberErr = "Must match xxxxxxxxx";
  } else {
    $finalCheck = true;
  }


  // building validation
  $stateResult = $_POST["building"];
  if (empty($buildingResult)) {
    $buildingErr = "Building is required";
    $finalCheck = false;
  } else if (!preg_match ("/^[a-zA-Z\s]+$/", $buildingResult)){
    $finalCheck = false;
    $buildingErr = "Must be letters only!";
  }

  // zipcode validation
  $roomResult = $_POST["room"];
  if (empty($roomResult)){
    $roomErr = "Room is required";
    $finalCheck = false;
  } else if (!preg_match ("/^[0-9]+$/",$roomResult)) {
    $finalCheck = false;
    $roomErr = "Room must contain only numbers!";
  } else {
    $finalCheck = true;
  }


  if ($finalCheck){
    echo "Name is : $firstnameResult <br> Email: $emailResult <br> Student ID:  $numberResult <br> Building:  $buildingResult <br> Room Number:  $roomResult <br>" ;
    echo "ORDER SUCCESSFUL! DELIVERY TIME IS 180 YEARS! <br>";



  	mysqli_stmt_execute($selectCustomer);
    mysqli_stmt_execute($selectGirlScout);
    mysqli_stmt_execute($selectPurchaseOrder);
    mysqli_stmt_execute($selectCookies);

  	$selectCustomer -> bind_result($cid);
    $selectGirlScout -> bind_result($gid);
    $selectPurchaseOrder -> bind_result($pid);


  	if($selectCustomer -> fetch()) { //check if customer is already in database
  		echo "Your ID is $cid <br>";
  	} else { // insert customer id
  		mysqli_stmt_execute($insertCustomer);
  		print_r($connection->error);
  		$cid = mysqli_stmt_insert_id($insertCustomer);
  		echo "Welcome, Your new customer ID is $cid <br>";
  	}

    if($selectGirlScout -> fetch()) {
      echo "Your GirlScout ID is $gid <br>";
    } else {
      mysqli_stmt_execute($insertGirlScout);
      print_r($connection->error);
      $gid = mysqli_stmt_insert_id($insertGirlScout);
      echo "Welcome, Your new Girlscout ID is $gid <br>";
    }

    if($selectPurchaseOrder -> fetch()) {
      echo "Your PID is $pid <br>";
    } else {
      mysqli_stmt_execute($insertPurchaseOrder);
  		print_r($connection->error);
  		$pid = mysqli_stmt_insert_id($insertPurchaseOrder);
  		echo "Welcome, Your new purchase ID is $pid <br>";
    }

    foreach ($_SESSION['cart']->order as $variety => $quantity) {
      $cost = $quantity * 5;
      mysqli_stmt_execute($insertCookies);
      print_r($connection->error);
    }
    $selectCookies -> bind_result($pid);

  	// close the connections
  	mysqli_stmt_close($selectCustomer);
  	mysqli_stmt_close($insertCustomer);
    mysqli_stmt_close($selectGirlScout);
    mysqli_stmt_close($insertGirlScout);
    mysqli_stmt_close($selectPurchaseOrder);
    mysqli_stmt_close($insertPurchaseOrder);
    mysqli_stmt_close($selectCookies);
    mysqli_stmt_close($insertCookies);
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


<h2>Checkout</h2>



<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<!--ALL FORMS  -->
<h3>Your Information: </h3>
<legend for = "firstname"> Name: <input id = "fname" type="text" name="firstname">
    <span class="info">* <?php echo $fNameErr;?></span>
<br><br>
</legend>


<legend for = "email"> Email:
    <input id = "email" type="text" name="email">
    <span class="info">* <?php echo $emailErr;?></span>
<br><br>
</legend>

<legend for = "studentId"> Student ID Number:
    <input id = "number" type="text" name="number">
    <span class="info">* <?php echo $numberErr;?></span>
<br><br>
</legend>


<legend for = "building"> Dorm Building: <input id = "building" type="text" name="building">
    <span class="info">* <?php echo $streetErr;?></span>
<br><br>
</legend>

<legend for = "room"> Room Number: <input id = "room" type="text" name="room">
    <span class="info">* <?php echo $zipcodeErr;?></span>
<br><br>
</legend>


    <input type="submit" name="submit" value="Submit" >

<p> * = required field </p>
</form>


<p>Here is your order: <?php



// Poor man's display of shopping cart

$SESS_ARRAY = $_SESSION['cart']->order;

$TOTAL_COST = 0;

// display cost
foreach ($SESS_ARRAY as $key => $value) {
  // get the actual name of cookie based off array key
  $TOTAL_COST += $value * 5;
}

// display nicely in a table
function build_table($_SESSION_ARRAY){

    // creates a form
    $html .= '<form method="post" action "">';
    // starts the table
    $html .= '<table>';
    // header row
    $html .= '<tr><th> Cookie </th> <th> Quantity </th> </tr>';

    // each row
    foreach($_SESSION['cart']->order as $key => $value){
      $displayName = ShoppingCart::$cookieTypes[$key];
      $html .= '<tr>';
      $html .= '<td>' . $displayName . '</td><td>' . $value . '</td>';
      $html .= '</tr>';

    }
    // finish table
    $html .= '</table>';
    $html .= '</form>';
    return $html;
}


echo build_table($SESS_ARRAY);

// total cost
echo '<hr><br\><span style="color:red;text-align:center;">TOTAL COST: $' . $TOTAL_COST . '</span>';

//if all passes are successful
if ($finalCheck){
  //echo "<br><br>SUCCESSFULLY SUBMITTED ORDER!";
  echo '<br><br><span style="color:#AFA;text-align:center;">Successfully submitted order! Please wait for the shipment!</span>';
  session_unset();  // remove all session variables
  session_destroy();
} else {
  echo '<br><br><span style="color:red;text-align:center;">Order not processed yet! Make sure all information is correct!</span>';

}
// session_unset();  // remove all session variables
// session_destroy();
?></p>

<p>Your credit card will be billed.  Thanks for the order!</p>

<p><a href="index.php">Shop some more!</a></p>

</body>
</html>
