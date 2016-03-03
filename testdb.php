#!/usr/bin/php
<?php
$db = new mysqli("localhost","root","july1696","it202");
if ($db->connect_errno > 0)
{
    echo __FILE__.__LINE__." ERROR: ".$db->connect_error.PHP_EOL;
    exit(-1);
}

$query = "select * from Students;";
$results = $db->query($query);

print_r($results);

while ($row = $results->fetch_assoc())
{
    print_r($row);
}

echo "We are connected to the DATABASE".PHP_EOL;
$d->close();
?>