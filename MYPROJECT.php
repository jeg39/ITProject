#!/usr/bin/php
<?php

class clientDB
{
  private db
  public function__construct()
    {
	$this->db = new mysqli("localhost","root","july1696","it202");
	
	#Checks to see if you get connected
	if ($this->db->connect_errno > 0)
	{
	    echo__FILE__.__LINE."failed to connect to database re:".$this->db->connect_error.PHP_EOL;
	    exit(0);
	}
	
	
    }
    
  public function__destruct()
    {
	
    }
}


?>