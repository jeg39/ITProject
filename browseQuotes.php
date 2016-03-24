<?php
require_once("randQuote.php");
require_once("clientAuth.php.inc");
$login = new randQuote("connect.ini");
$login2 = new clientDB("connect.ini");
$username = $_SESSION["username"];
$password =$_SESSION["password"];
$response2 = $login2->checkAdmin($username,$password);
$response = $login->browseQuotes();
for($i = 0;$i < sizeof($response);$i++)
  if($response2 == 1)
    {
	$id = $response[$i][0];
	$quote = $response[$i][1];
	$author = $response[$i][2];
	echo "<p>'$quote'<br>'$author'</p>";
	echo "<a href='deleteQuote.php?type=$id'>Flag</a><br>";
	//echo "<a href='approveQuote.php?type=$id'>Approve</a>";
	
    }
  else
  {
      $id = $response[$i][0];
	$quote = $response[$i][1];
	$author = $response[$i][2];
	echo "<p>'$quote'<br>'$author'</p>";
	//echo "<a href=browseQuotes.php</a>";
  }

?>