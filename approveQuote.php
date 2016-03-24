<?php
require_once("randQuote.php");
require_once("browseQuotes.php");
$type = $_GET["type"];
$login = new randQuote("connect.ini");
if($type == 1)
{
    $id = $_GET["id"];
    $response2 = $login->quoteApproval($id);
}

$response = $login->getAllQuotes();

for($i = 0;$i < sizeof($response);$i++)
{
	$id = $response[$i][0];
	$quote = $response[$i][1];
	$author = $response[$i][2];
	echo "<p>'$quote'<br>'$author'</p>";
	echo "<a href='approveQuote.php?type=1&id=$id'>Approve</a>";
	//echo "<a href='deleteQuote.php?type=$id>Reject</a><br>";
	
}



?>