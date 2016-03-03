#!/usr/bin/php
<?php

class clientDB
{
      private $db;
      public function __construct()
      {
	    $this->db = new mysqli("localhost","root","july1696","it202");
	    if ($this->db->connect_errno > 0)
	  {
      echo __FILE__.__LINE__."failed to connect to database re:".$this->db->connect_error.PHP_EOL;
      exit(0);
	  }
	  echo "db connected!".PHP_EOL;
      }
      
      
      public function __destruct()
      
      {
	  $this->db->close();
	  echo"db closed".PHP_EOL;
	 
      }
      
       public function getClientId($name)
      {
	  $query = "select * from clients where clientName='$name';";
	  $results = $this->db->query($query);
	  if (!$results)
	  {
	      echo "error with results: ".$this->db->error.PHP_EOL;
	      return 0;
	  } 
	  $client = $results->fetch_assoc();
	  if (isset($client['clientID']))
	  {
	      return $client['clientID'];
	  }
	  return 0;
      }
      
      
      public function validateClient($name,$passwod)
      {
	  if ($this->getClientId($name) == 0)
	  {
	      echo "user $name does exist!".PHP_EOL;
	      return false;
	  }
	  $query = "select * from clients where clientName='$name';";
	  $results = $this->db->query($query);
	  if (!results)
	      {
		  echo "error with results: ".$this->db->error.PHP_EOL;
		  return false;
	      }
	  $client = $results->fetch_assoc();
	  {
	  if ($client['clientPW'] == $password)
	      {
		  return true;
	      }
	  }
	  return false;
      }
     
      public function addNewClient($name,$password)
      {
	  if ($this->getClientId($name) == 0)
	  {
	      echo " user $name already exist.".PHP_EOL;
	      return false;
	  }
	 
	  $now = date("Y-m-d h:i:s",time());
	  $this->name = $name;
	  $this->password = $password;
	  $insert = "insert into clients(clientName,clientPW,firstLogin,lastLogin)
	  values ('$name','$password','$now','$now')";
	  $results = $this->db->query($insert);
	  if (!$results)
	  {
	      echo "error: ".$this->db->error.PHP_EOL;
	  }
      }
}











?>