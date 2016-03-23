<?php
require_once("randQuote.php");
$request = $_POST['request'];
$login = new randQuote("connect.ini");
$response = $login->getRandQuote();

echo $response['quoteActual'];
echo $response['author'];

// for the marking of quotes, i have to check if the person is an admin by checking the admin columns to see if it equals 1
?>
