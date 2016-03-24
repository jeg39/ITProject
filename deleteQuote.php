<?php
require_once("randQuote.php");
$quoteID = $_GET["type"];
$login = new randQuote("connect.ini");
//$response = $login->quoteApproval($quoteID);
$response2 = $login->deleteQuote($quoteID);
header("Location:browseQuotes.php");

?>