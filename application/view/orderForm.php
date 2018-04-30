<?php 
session_start();
require 'application/model/dbconnect.php';
$connection = connect_to_db("COOP");
require 'application/model/queries.php';
?>

<!DOCTYPE html>

<html lang="en">

<head>
<title>Coop Store Online</title>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script language="javascript">

// Display the image corresponding to the food item that is selected.
function updateImage () {
    var menu = document.getElementById("variety");
    var foodImage = document.getElementById("foodImage");
    var footerImage = document.getElementById("footerImage");
    footerImage.innerHTML = menu.options[menu.options.selectedIndex].value;
    foodImage.src = 
        'public/img/' + menu.options[menu.options.selectedIndex].value + '.jpg';
}


// Determine which selection should appear in the menu and which variety should
// be displayed.
function setDefaultVarietyAndQuantity () {
    // Deal with food varieties.  If one was posted, use it.  Otherwise, use
    // whatever default the browser gives us.
    var defaultVariety = "<?php echo $variety ?>";
    var option = document.getElementById(defaultVariety);
    if (option) {
        document.getElementById("variety").selectedIndex = option.index;
    }

    // Deal with cookie quantities. If one was posted, use it. Otherwise, use 1.
    var quantity = "<?php echo $quantity ?>";
    if (quantity.length == 0) quantity = "1";
    document.getElementById("quantity").value = quantity;
}

// Clear the error/update message.
function clearMessage () {
    document.getElementById("message").innerHTML = "";
}

</script>
</head>


<!-- Every time this page loads, set the initial state of the form and
     update the image to match. -->
<body onload="setDefaultVarietyAndQuantity(); updateImage();">

<h2 class="w3-container w3-blue">Coop Fountain Order Form</h2>

<p>Please use the form below to add food items to your shopping cart.
Thank you!</p>

<form method="post">
<table class="w3-table w3-striped w3-border">
  <tr><td>Food Item</td><td>Quantity</td></tr>

  <tr><td><!-- Any time the selection changes, update the image and clear the message. -->
          <select id="variety" name="variety" onchange="updateImage(); clearMessage();">
<?php 
            // We generate the options using information from the ShoppingCart class.

            foreach (ShoppingCart::$foodTypes as $key => $displayName) {
                echo "<option id=\"$key\" value=\"$key\">$displayName</option>";
            }
?>
          </select></td>

      <td><!-- Any time the quantity changes, clear the message -->
          <input type="text" id="quantity" name="quantity" onChange="clearMessage();"/></td>

      <td><input type="submit" name="update" value="Add to Cart"/></td><td><input type="submit" name="submitorder" value="Checkout"/></td>
  </tr>
</table>

<!-- This is where updated food images are placed. -->
<div class="w3-card-4" style="width:25%;">
  <img id="foodImage"/><br>
  <footer class="w3-container w3-blue">
      <h5 id="footerImage"></h5>
  </footer>

</div>
<div>
<?php
    $query6 = "SELECT type, COUNT(*) FROM Food GROUP BY type ORDER BY COUNT(quantity) DESC";

    $result = perform_query($connection, $query6);
    $orders = mysqli_num_rows($result);


    $index = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        if($index == 0){
          $pop = $row['type'];
          echo "<p>Most Popular Item: $pop </p>";
          
        }
        $index =1;
      
        
    }
?>
</div>

<!-- This is where messages are displayed. -->
<span style="color:red" id="message"><?php echo "$message" ?></span>
</body>
</html>
