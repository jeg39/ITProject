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
	$randQuery = "select * from quotes where approveReject = 1 and inaccurate = 0 order by rand() limit 1;";
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
	$query = "select * from quotes where approveReject = 1 and inaccurate = 0;";
	$results = $this->quoteDB->query($query);
	$allQuotes = array();
	if($results)
	{
	    while($quotes = $results->fetch_assoc())
	    {
		$allQuotes[$counter] = array($quotes["quoteId"],$quotes["quoteActual"], $quotes["author"]);
		$counter++;
	    }
	}
	return $allQuotes;
    }
    public function getAllQuotes()
    {
	$counter = 0;
	$query = "select * from quotes;";
	$results = $this->quoteDB->query($query);
	$allQuotes = array();
	if($results)
	{
	    while($quotes = $results->fetch_assoc())
	    {
		$allQuotes[$counter] = array($quotes["quoteId"],$quotes["quoteActual"], $quotes["author"]);
		$counter++;
	    }
	}
	return $allQuotes;
    }
    
    public function deleteQuote($quoteId)
    {
	$deleteQuoteQuery = "delete from quotes where quoteId = $quoteId";
	$results = $this->quoteDB->query($deleteQuoteQuery);
	if(!$results)
	{
	    echo "error with results :".$this->quoteDB->error.PHP_EOL;
	}
    }
    public function quoteApproval($id)
    {	
	//$getQuery = "select * from quotes;";
	//$getQuery = "select * from quoteApproval";
	//$results = $this->quoteDB->query($getQuery);
	//$approvalArry = $results->fetch_assoc();
	//$approveAdder = $approvalArry['quoteAdder'];
	//$approveQuote = $approvalArry['quoteForApproval'];
	//$approveAuthor = $approvalArry['authorOfQuote'];
	$update = "update quotes set approveReject = 1 where quoteId = $id;";
	$update2 = "update quotes set inaccurate = 0 where quoteId = $id;";
	//$insert = "insert into quotes(quoteAdder,quoteActual,author,approveReject) 
	//	  values ($approveAdder,$approveAuthor,$approveQuote,1);";
	$updateResults = $this->quoteDB->query($update);
	$updateResults2 = $this->quoteDB->query($update2);
}
    public function addQuote($newQuote,$whoSaidQuote)
    {
	$username = $_SESSION["username"];
	$password = $_SESSION["password"];
	$login = new clientDB("connect.ini");
	$check = $login->checkAdmin($username,$password);
	if($check == 1)
	{
	    $insert = "insert into quotes(quoteActual,author,approveReject,inaccurate) values ('$newQuote','$whoSaidQuote',1,0);";
	    $results = $this->quoteDB->query($insert);
	    if (!$results)
	      {
		  //$this->logger->log
		  echo "error: ".$this->quoteDB->error.PHP_EOL;
	      
	      }
	      echo "<script type=\"text/javascript\">".
        "alert('Succesfully added quote to database!');window.location = 'adminHomepage.html';".
        "</script>";
        
	      //echo json_encode("Successfully added quote to database");
	      //return array("success"=>true);
	}
	else
	{
	    $insert = "insert into quotes(quoteAdder,quoteActual,author,approveReject,inaccurate) 
		       values ('$username','$newQuote','$whoSaidQuote',0,0);";
	    $results = $this->quoteDB->query($insert);
	    if (!$results)
	      {
		  //$this->logger->log
		  echo "error: ".$this->quoteDB->error.PHP_EOL;
	      
	      }
	    echo "<script type=\"text/javascript\">".
        "alert('Submitted quote for approval!');window.location = 'homepage.html';".
        "</script>";
	}
    }
    public function inaccuracy()
    {
	$query = "select * from quotes;";
	$results = $this->quoteDB->query($query);
	$arry = $results->fetch_assoc();
	if($arry["inaccurate"] == 0)
	{
	    $update = "update quotes set inaccurate = 1 where inaccurate = 0;";
	    $updateResults = $this->quoteDB->query($update);
	    header("Location:browseQuotes.php");
	}

    }
}








?>