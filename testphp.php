#!/usr/bin/php
<?php 
echo "begin script ".$argv[0].PHP_EOL;

class Student
{
   private $name;
   private $address;
   private $gpa;
   private $year;
   public function __construct($name)#creates a constructer
   {
      $this->name = $name;# "this" changes private or public variables with whatever variable you give it
   }
   public function printName()
   {
      echo "name: ".$this->name.PHP_EOL;
   }
   public function setGPA($gpa)
   {
      $this->gpa = $gpa;
      echo "gpa: ".$gpa.PHP_EOL;
   }
}
$myStudent = new Student("Steve");
$myStudent->printName();
$myStudent->setGPA(4.0);

$var = "some value";
$number =  248573289;
$realNumber = 1234.453;
$arr = array();
//print_r($arr);

echo "end script ".$argv[0].PHP_EOL;
?>