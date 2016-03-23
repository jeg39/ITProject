<?php
require_once("clientAuth.php.inc");
class randQuote
{
    private $quoteDB;
    private $ini;
    
    public function __construct($iniFile)
    {
	$ini = parse_ini_file($iniFile,true);
	$this->quoteDB = new mysqli(
	      $ini['loginDB']['host'],
	      $ini['loginDB']['user'],
	      $ini['loginDB']['password'],
	      $ini['loginDB']['db']);
	if ($this->quoteDB->connect_errno > 0)
	{
	    echo __FILE__.__LINE__."failed to connect to database re:".$this->quoteDB->connect_error.PHP_EOL;
	    exit(0);
	}
    }
    public function __destruct()
    {
	$this->quoteDB->close();
    }
    public function getRandQuote()
    {
	$randQuery = "select * from quotes order by rand() limit 1;";
	$results = $this->quoteDB->query($randQuery);
	if(!$results)
	{
	    echo "error with results :".$this->quoteDB->error.PHP_EOL;
	}
	else
	{
	    $randResults = $results->fetch_assoc();
	    return $randResults;
	}
    }
    public function browseQuotes()
    {
	$counter = 0;
	$query = "select * from quotes;";
	$results = $this->quoteDB->query($query);
	$allQuotes = array();
	if($results)
	{
	    while($quotes = $results->fetch_assoc())
	    {
		$allQuotes[$counter] = array($quotes["quoteActual"], $quotes["author"]);
		$counter++;
	    }
	}
	return $allQuotes;
    }
    public function addQuote($newQuote,$whoSaidQuote)
    {
	$username = $_SESSION["username"];
	$password = $_SESSION["password"];
	$login = new clientDB("connect.ini");
	$check = $login->checkAdmin($username,$password);
	if($check == 1)
	{
	    $insert = "insert into quotes(quoteActual,author) values ('$newQuote','$whoSaidQuote');";
	    $results = $this->quoteDB->query($insert);
	    if (!$results)
	      {
		  //$this->logger->log
		  echo "error: ".$this->quoteDB->error.PHP_EOL;
	      
	      }
	      echo "Successfully added quote to database".PHP_EOL;
	      return array("success"=>true);
	}
	else
	{
	    $insert = "insert into quoteApproval(quoteAdder,quoteForApproval,authorOfQuote) 
		       values ('$username','$newQuote','$whoSaidQuote');";
	    $results = $this->quoteDB->query($insert);
	    if (!$results)
	      {
		  //$this->logger->log
		  echo "error: ".$this->quoteDB->error.PHP_EOL;
	      
	      }
	    echo "Quote summited for approval.".PHP_EOL;
	}
    }
}








?>