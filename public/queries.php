<?php
// first QUERY
$query = "INSERT INTO Customer (name, streetAddress, city, state, zipcode)
			 VALUES (?,?,?,?,?)";

$insertCustomer = $connection->prepare($query);
if (!$insertCustomer) {
	 echo "Error preparing customer query" . $connection->error;
} else{
	$insertCustomer -> bind_param ("ssssi", $firstnameResult, $streetResult, $cityResult, $stateResult, $zipcodeResult);
}


$query = "SELECT id FROM Customer WHERE name=?";
$selectCustomer = $connection-> prepare($query);
$selectCustomer->bind_param("s",$firstnameResult);

// second QUERY
$queryTwo = "INSERT INTO GirlScout (name) VALUES (?)";

$insertGirlScout = $connection->prepare($queryTwo);
if (!$insertGirlScout) {
	echo "Error preparing girlscout query" . $connection->error;
} else {
	$insertGirlScout -> bind_param ("s", $usernameResult);
}

$queryTwo = "SELECT id FROM GirlScout WHERE name = ?";
$selectGirlScout = $connection-> prepare($queryTwo);
$selectGirlScout->bind_param("s", $usernameResult);


// third QUERY
$queryThree = "INSERT INTO PurchaseOrder (cid, gid) VALUES (?,?)";

$insertPurchaseOrder = $connection->prepare($queryThree);
if (!$insertPurchaseOrder) {
	echo "Error preparing purchase order query" . $connection->error;
} else {
	$insertPurchaseOrder -> bind_param ("ii", $cid, $gid);
}

$queryThree = "SELECT id FROM PurchaseOrder WHERE cid = ?";
$selectPurchaseOrder = $connection-> prepare($queryThree);
$selectPurchaseOrder->bind_param("i", $cid);


//fourth QUERY
$queryFour = "INSERT INTO Cookies (order_id, variety, quantity, price) VALUES (?, ?, ?, ?)";

$insertCookies = $connection->prepare($queryFour);

if(!$insertCookies) {
	echo "Error preparing cookie order query". $connection->error;
} else {
	$insertCookies-> bind_param("isii", $pid, $variety, $quantity, $cost);
}

$queryFour = "SELECT id FROM Cookies WHERE pid = ?";
$selectCookies = $connection-> prepare($queryFour);




?>
