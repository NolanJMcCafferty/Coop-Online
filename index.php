<?php
session_start();
?>

<!DOCTYPE html>

<html lang="en">

<head>
<title>Coop Fountain Online</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script language="javascript"></script>

<style>

.button {
    background-color: #f4511e;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    font-family: inherit;
    float: left;
    margin: 4px 2px;
    opacity: 0.6;
    transition: 0.3s;
    cursor: pointer;
    font-family: Helvetica;
}

.button:hover {opacity: 1}

</style>

</head>


<body>

<div class="w3-container w3-jumbo w3-blue">Coop Fountain Online</div><br>

<img src="public/img/cecil.jpg">
<img src="public/img/coop.jpg" style="float:right; padding: 30px; width:45%;"><br><br>
<br><center><a class="w3-btn w3-large w3-xxlarge w3-hover-grey w3-orange" href="order.php">Ready to Order!</a></center>



<input class = "button" type="button" onclick="location.href='application/view/admin.php';" value="Admin" />

</body>
</html>
