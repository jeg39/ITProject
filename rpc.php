
<?php
require_once("clientAuth.php.inc");

//$request = $_POST['request'];
$request = json_decode(file_get_contents("php://input"),true);
$response = "FUCK<p>";
$check = 0;
switch($request["request"])
{
    case "Login":
	$username = $request['username'];
	$password = $request['password'];
	$login = new clientDB("connect.ini");
	$response = $login->validateClient($username,$password);
	if ($response['success']===true)
	{
		$response = "Login Successful!";
		$userCheck = $login->checkAdmin($username,$password);
		if ($userCheck == 1)
		{
		   echo 1;//header("Location:adminHomepage.html");
		}
		else
		{
		   echo 0;//header("Location:homepage.html");
		}
	}
	else
	{
		$response = "Login Failed:".$response['message'];
	}
	break;
    case "Register":
	$username =$request['username'];
	$password =$request['password'];
	$login = new clientDB("connect.ini");
	$response = $login->addNewClient($username,$password);
	if ($response['success']===true)
	{
		$response = "Registration Successful!";
		//header("Location:homepage.html");
	}
	else
	{
		$response = " Try another username.";
		//header("Location:index.html");
	}
}
echo json_encode($response);

?>

