<?php
require_once("randQuote.php");
$request = $_POST['request'];
$addQuote = $_POST['addQuote'];
$author = $_POST['author'];
$login = new randQuote("connect.ini");
$response = $login->addQuote($addQuote,$author);
//echo $response["success"];
?>