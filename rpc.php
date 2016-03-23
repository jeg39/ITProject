<?php
require_once("clientAuth.php.inc");
$request = $_POST['request'];
$response = "FUCK<p>";
switch($request)
{
    case "Login":
	$username = $_POST['username'];
	$password = $_POST['password'];
	$login = new clientDB("connect.ini");
	$response = $login->validateClient($username,$password);
	if ($response['success']===true)
	{
		$response = "Login Successful!<p>";
		$userCheck = $login->checkAdmin($username,$password);
		if ($userCheck == 1)
		{
		    header("Location:adminHomepage.html");
		}
		else
		{
		   header("Location:homepage.html"); 
		}
	}
	else
	{
		$response = "Login Failed:".$response['message']."<p>";
	}
	break;
    case "Register":
	$username =$_POST['username'];
	$password =$_POST['password'];
	$login = new clientDB("connect.ini");
	$response = $login->addNewClient($username,$password);
	if ($response['success']===true)
	{
		$response = "Registration Successful!<p>";
		header("Location:homepage.html");
	}
	else
	{
		$response = " Try another username.<p>";
		header("Location:index.html");
	}
}
echo $response;

?>