<?php

session_start();
require '../model/dbconnect.php';
$connection = connect_to_db("COOP");
require '../model/queries.php';
?>


<html>
<head>
  <title> Admin Page </title>

  <style>
  body{
    background-color: w3-hover-grey;
  }
  table{
    font-family: Helvetica;
    margin: 0 auto;
  }
  td,th {
    text-align: center;
    border-bottom: 1px solid #ddd;
  }
  h1{
    font-family: Helvetica;
    text-align: center;
  }



  </style>
</head>

<body>

  <h1>Admin Page!</h1>


  <?php

    $sql = "SELECT * FROM FoodItems A, Food B WHERE B.foodid = A.fid;";
    $result = mysqli_query($connection, $sql);
    $resultCheck = mysqli_num_rows($result);


    if ($resultCheck > 0){
      echo "<table>";
      echo "<tr> <th> OrderID </th> <th> Item </th> <th> Quantity </th> ";
      while($row = mysqli_fetch_assoc($result)){



        $col1 = $row['orderid'];
        $col2 = $row['name'];
        $col3 = $row['quantity'];

        echo "<tr>
        <td>$col1</td>
        <td>$col2</td>
        <td>$col3</td>
        <td><button name = 'id'>Delete</button></td>
        </tr>\n";
      }
      echo "</table>\n";


    }





  ?>

</body>


</html>
