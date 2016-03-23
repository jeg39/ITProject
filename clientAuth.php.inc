<?php
//require_once ("errorLogger.php.inc");
session_start();
class clientDB
{
      private $db;
      private $salt;
  //    private $logger;
      public function __construct($iniFile)
      {
	    $ini = parse_ini_file($iniFile,true);
//	    $this->logger = new errorLogger("/var/log/it202.log");
	    $this->db = new mysqli(
		$ini['loginDB']['host'],
		$ini['loginDB']["user"],
		$ini['loginDB']["password"],
		$ini['loginDB']["db"]);
	    $this->salt = $ini['loginDB']['salt'];
	    if ($this->db->connect_errno > 0)
	  {
      //$this->logger->log
      echo __FILE__.__LINE__."failed to connect to database re:".$this->db->connect_error.PHP_EOL;
      exit(0);
	  }
	  //$this->logger->log
	 // echo "Testing...";
      }
      
      
      public function __destruct()
      
      {
	  $this->db->close();
	 // echo "db closed";
	 
      }
      
       public function getClientId($name)
      {
	  $query = "select * from users where userName='$name';";
	  $results = $this->db->query($query);
	  if (!$results)
	  {
	      //$this->logger->log
	      echo "error with results: ".$this->db->error.PHP_EOL;
	      return 0;
	  } 
	  $client = $results->fetch_assoc();
	  if (isset($client['userID']))
	  {
	      return $client['userID'];
	  }
	  return 0;
      }
      private function saltPassword($password)
      {
	  return $this->db->real_escape_string(sha1($password.$this->salt));
      }
      
      public function validateClient($name,$password)
      {
	  if ($this->getClientId($name) == 0)
	  {
	      return array("success"=>false,"message"=>"user does not exist!");
	  }
	  $query = "select * from users where userName='$name';";
	  $results = $this->db->query($query);
	  if (!$results)
	      {
		  return array("success"=>false,"message"=>"db failure");
	      }
	      
	  $client = $results->fetch_assoc();
	  {
	  if ($client['userPass'] == $this->saltPassword($password))
	      {
		  return array ("success"=>true);
	      }
	  }
	  // This creates an index called "username" and it set it to the username. Used to track users. 
	 // header("Location:homepage.html");
	  $_SESSION["username"] = $name;
	  return array("success"=>false,"message"=>"failed to match password");
      }
      public function checkAdmin($name,$password)
      {
	  $query = "select * from users where userName = '$name';";
	  $results = $this->db->query($query);
	  if(!$results)
	  {
	      return array("success"=>false,"message"=>"db failure");
	  }
	  $adminCheck = $results->fetch_assoc();
	  $_SESSION["username"] = $name;
	  $_SESSION["password"] = $password;
	  $username = $_SESSION["username"];
	  if ($username == $adminCheck["userName"] && $adminCheck["admin"] == 1)
	  {
	      return 1;
	  }
	  else
	  {
	      return 0;
	  }
	  
      }
     
      public function addNewClient($name,$password)
      { 
	  if ($this->getClientId($name) != 0)
	      {
	      //$this->logger->log
	      echo " user $name already exist.".PHP_EOL;
	      $response = array("message"=>"user $name already exist","success"=>false);
	      return $response;
	      }
	  $uLength = strlen($name);
	  $pLength = strlen($password);
	  if ($uLength >= 4 && $uLength <=10)
	      {
		  echo "".PHP_EOL;
	      }
	  else
	      {
		  echo "Username has to be between 4 and 10 characters!".PHP_EOL;
	      }    
	  if ($pLength >=8 && $pLength <= 16)
	      {
		  echo "".PHP_EOL;
	      }
	  else
	      {
		  echo "Password has to be between 8 and 16 characters".PHP_EOL;
	      }
	  
	 
	  $now = date("Y-m-d h:i:s",time());
	  $name = $this->db->real_escape_string($name);
	  $password = $this->saltPassword($password);
	  $insert = "insert into users(userName,userPass,admin,firstLogin,lastLogin)
	  values ('$name','$password',0,'$now','$now')";
	  $results = $this->db->query($insert);
	  if (!$results)
	  {
	      //$this->logger->log
	      echo "error: ".$this->db->error.PHP_EOL;
	  }
	  return array("success"=>true);
      }
}











?>