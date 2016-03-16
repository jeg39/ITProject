<?php
require_once ("errorLogger.php.inc");
class clientDB
{
      private $db;
      private $salt;
      private $logger;
      public function __construct($iniFile)
      {
	    $ini = parse_ini_file
	    $this->logger = errorLogger("/var/log/apache2/error.log");
	    $this->db = new mysqli(
		$ini['loginDB']['localhost'],
		$ini['loginDB']['root'],
		$ini['loginDB']['july1696'],
		$ini['loginBD']['users']);
	    $this->salt = $ini['loginDB']['salt'];
	    if ($this->db->connect_errno > 0)
	  {
      $this->logger->log( __FILE__.__LINE__."failed to connect to database re:".$this->db->connect_error);
      exit(0);
	  }
	  $this->logger->log("Testing...");
      }
      
      
      public function __destruct()
      
      {
	  $this->db->close();
	  echo"db closed".PHP_EOL;
	 
      }
      
       public function getClientId($name)
      {
	  $query = "select * from users where userName='$name';";
	  $results = $this->db->query($query);
	  if (!$results)
	  {
	      $this->logger->log("error with results: ".$this->db->error);
	      return 0;
	  } 
	  $client = $results->fetch_assoc();
	  if (isset($client['clientID']))
	  {
	      return $client['clientID'];
	  }
	  return 0;
      }
      private function saltPassword($password)
      {
	  return $this->db->real_escape_string(sha1($password.$this->salt));
      }
      
      public function validateClient($name,$passwod)
      {
	  if ($this->getClientId($name) == 0)
	  {
	      return array("success"=>false,"message"=>"user does not exist!")
	  }
	  $query = "select * from users where userName='$name';";
	  $results = $this->db->query($query);
	  if (!results)
	      {
		  return array("success"=>false,"message"=>"db failure")
	  }
	      }
	  $client = $results->fetch_assoc();
	  {
	  if ($client['clientPW'] == $this->saltPassword($password)
	      {
		  return array ("success"=>true);
	      }
	  }
	  return array("success"=>false,"message"=>"failed to match password");
      }
     
      public function addNewClient($name,$password)
      {
	  if ($this->getClientId($name) != 0)
	  {
	      $this->logger->log(" user $name already exist.");
	      $response = array("message"=>"user $name already exist","success"=>false);
	      return response;
	  }
	 
	  $now = date("Y-m-d h:i:s",time());
	  $name = $this->db->real_escape_string($name);
	  $password = $this->saltPassword($password);
	  $insert = "insert into users(userName,userPass,firstLogin,lastLogin)
	  values ('$name','$password','$now','$now')";
	  $results = $this->db->query($insert);
	  if (!$results)
	  {
	      $this->logger->log("error: ".$this->db->error);
	  }
	  return array("success"=>true);
      }
}











?>