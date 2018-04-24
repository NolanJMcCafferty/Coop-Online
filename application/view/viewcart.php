<?php 
session_start();

?>
<html>
  <head></head>

  <body>
   
    <form method='post'>
      <table class="w3-table w3-striped w3-border">
          <tr> <th>Food Item</th> <th>Quantity</th> <th>Price</th></tr> 
 

          <?php 
          
          foreach ($shoppingCart as $variety=>$quantity) {
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
    </form>

  </body>
</html>
