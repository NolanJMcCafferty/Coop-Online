<?php
// first QUERY
$query = "INSERT INTO Customer (name, email, studentNum, building, room)
			 VALUES (?,?,?,?,?)";

$insertCustomer = $connection->prepare($query);
if (!$insertCustomer) {
	 echo "Error preparing customer query" . $connection->error;
} else{
	$insertCustomer -> bind_param ("ssisi", $nameResult, $emailResult, $numberResult, $buildingResult, $roomResult);
}

// second query
$query2 = "SELECT cid FROM Customer WHERE studentNum=?";
$selectCustomer = $connection-> prepare($query2);
$selectCustomer->bind_param("s",$numberResult);



// third QUERY
$query3 = "INSERT INTO PurchaseOrder (cid) VALUES (?)";
$insertPurchaseOrder = $connection->prepare($query3);
if (!$insertPurchaseOrder) {
	echo "Error preparing purchase order query" . $connection->error;
} else {
	$insertPurchaseOrder ->bind_param("i", $cid);
}

// fourth query
$query4 = "INSERT INTO Food (orderid, type, quantity, price) VALUES (?, ?, ?, ?)";
$insertFood = $connection->prepare($query4);
if(!$insertFood) {
	echo "Error preparing food order query". $connection->error;
} else {
	$insertFood-> bind_param("isii", $pid, $fooditem, $quantity, $cost);
}

?>
