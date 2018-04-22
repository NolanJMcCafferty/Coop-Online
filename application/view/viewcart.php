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
              
          		echo "<tr>
                <td>$variety</td>
                <td>$quantity</td>
                <td>$5</td>
                </tr>";
           }

           
           ?>
      </table>
    </form>

  </body>
</html>