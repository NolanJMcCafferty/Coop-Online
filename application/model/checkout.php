<?php
// Include the ShoppingCart class.  Since the session contains a
// ShoppingCard object, this must be done before session_start().
require "../application/cart.php";
session_start();
require 'dbconnect.php';
$connection = connect_to_db("GSC");
require 'queries.php';
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
$fNameErr = $lNameErr = $emailErr = $numberErr = $streetErr = $stateErr = $cityErr = $zipcodeErr = $usernameErr = $troopErr = "";

// variables to hold
$finalCheck = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // firstname validation
  $firstnameResult = $_POST["firstname"];
  if (empty($firstnameResult)) {
    $fNameErr = "Name is required";
    $finalCheck = false;
  } else if (!preg_match ("/^[a-z ,.'-]+$/i", $firstnameResult)){
    $finalCheck = false;
    $fNameErr = "Must contain only letters!";
  } else {
    $finalCheck = true;
  }

  // lastname validation
  $lastnameResult = $_POST["lastname"];
  if (empty($lastnameResult)) {
    $lNameErr = "Name is required";
    $finalCheck = false;
  } else if (!preg_match ("/^[a-zA-Z\s]+$/", $firstnameResult)){
    $finalCheck = false;
    $lNameErr = "Must contain only letters!";
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

  // checks to see if username is correct
  $usernameResult = $_POST["username"];
  if (empty($usernameResult)) {
    $usernameErr = "Username is required";
    $finalCheck = false;
  } else if ((!preg_match ("/^[a-z]{3,}$/i", $usernameResult))){
    $finalCheck = false;
    $usernameErr = "Must be 3 characters or more and only letters!";
  } else {
    $finalCheck = true;
  }

  // number validation
  $numberResult = $_POST["number"];
  if (empty($numberResult)) {
    $numberErr = "Phone number is required";
    $finalCheck = false;
  } else if (!preg_match ("/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/", $numberResult)){
    $finalCheck = false;
    $numberErr = "Must match xxx-xxx-xxxx!";
  } else {
    $finalCheck = true;
  }

  // street validation
  $streetResult = $_POST["street"];
  if (empty($streetResult)) {
    $streetErr = "Street is required";
    $finalCheck = false;
  } else {
    $finalCheck = true;
  }

  // city validation
  $cityResult = $_POST["city"];
  if (empty($cityResult)) {
    $cityErr = "City is required";
    $finalCheck = false;
  } else if (!preg_match ("/^[a-zA-Z\s]+$/", $cityResult)){
    $finalCheck = false;
    $cityErr = "Must be letters only!";
  } else {
    $finalCheck = true;
  }

  // state validation
  $stateResult = $_POST["state"];
  if (empty($stateResult)) {
    $stateErr = "State is required";
    $finalCheck = false;
  } else if (!preg_match ("/^[a-zA-Z\s]+$/", $stateResult)){
    $finalCheck = false;
    $stateErr = "Must be letters only!";
  }

  // zipcode validation
  $zipcodeResult = $_POST["zipcode"];
  if (empty($zipcodeResult)){
    $zipcodeErr = "Zipcode is required";
    $finalCheck = false;
  } else if (!preg_match ("/^[0-9]+$/",$zipcodeResult)) {
    $finalCheck = false;
    $zipcodeErr = "Zipcode must contain only numbers!";
  } else {
    $finalCheck = true;
  }

  // troop validation
  $troopResult = $_POST["troop"];
  if (empty($troopResult)) {
    $troopErr = "Troop name is required";
    $finalCheck = false;
  } else if (!preg_match ("/^[a-zA-Z\s]+$/",$troopResult)){
    $finalCheck = false;
    $troopErr = "Letters only!";
  } else {
    $finalCheck = true;
  }


  if ($finalCheck){
    echo "First name is : $firstnameResult <br> Street: $streetResult <br> City:  $cityResult <br> State:  $stateResult <br> Zipcode:  $zipcodeResult <br>" ;
    echo "Username is: " . "$usernameResult <br>" ;
    echo "ORDER SUCCESSFUL! SHIPPING TIME IS 180 YEARS! <br>";



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

  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" >

  <!-- jQuery  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <!-- SCRIPT FOR AUTOCOMPLETE IN JQUERY WITH OWN STYLE -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />

  <!-- Your own CSS  -->
  <link rel="stylesheet" href="css/validate.css">
  <!-- Your own JavaScript  -->
  <script src="js/validate.js"></script>

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


<legend for = "email"> E-mail:
    <input id = "email" type="text" name="email">
    <span class="info">* <?php echo $emailErr;?></span>
<br><br>
</legend>

<legend for = "number"> Phone Number:
    <input id = "number" type="text" name="number">
    <span class="info">* <?php echo $numberErr;?></span>
<br><br>
</legend>


<legend for = "street"> Street: <input id = "street" type="text" name="street">
    <span class="info">* <?php echo $streetErr;?></span>
<br><br>
</legend>

<legend for = "city"> City: <input id = "city" type="text" name="city">
    <span class="info">* <?php echo $cityErr;?></span>
<br><br>
</legend>

<legend for = "state"> State: <input id = "state" type="text" name="state">
    <span class="info">* <?php echo $streetErr;?></span>
<br><br>
</legend>

<legend for = "zipcode"> Zipcode: <input id = "zipcode" type="text" name="zipcode">
    <span class="info">* <?php echo $zipcodeErr;?></span>
<br><br>
</legend>

<h3>Girl Scout Information: </h3>
<legend for = "username"> Username:
    <input id = "username" type="text" name="username">
    <span class="info">* <?php echo $usernameErr;?></span>
<br><br>
</legend>

<legend for = "troop"> Troop Name:
    <input id = "troop" type="text" name="troop">
    <span class="info">* <?php echo $troopErr;?></span>
<br><br>
</legend>


    <input type="submit" name="submit" value="Submit" >

<p> * = required form </p>
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

<p><a href="index4.php">Shop some more!</a></p>

</body>
</html>
