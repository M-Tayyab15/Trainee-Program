<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php 
// variables:
$name = "Tayyab Mansoor";
$version = phpversion();
$title = "Day 1 php practice";
$a = 5; $b = 10;


?>

<h1 style= "color:Blue; text-align:center; ">
    <?php echo "$title"; ?>
</h1>
    <h1>
        <?php echo "hello $name"; ?>
    </h1>


    <h2> 
        <?php echo "Version of PHP is $version"; ?>
        <?php eCHo " <br> Php is not case sensitive <br>"; ?>
        <?php echo "but variables are. $NAme  <br>"; ?>

        <?php // comments
        /*
        multi line
        */ 
         
        echo  " sum of 2 variables are:" . $sum = $a + $b;
        ?>
    </h2>

    <h5>
        <?php echo var_dump($sum); ?>
</h5>



<h6>
<?php
$x = 5;
$y = 10;

function Test() {
  global $x, $y;
  $y = $x + $y;
} 

Test(); 
echo $y;    
?>
</h6>



<p>
<?php
function Test2() {
  static $x = 0;
  echo $x;
  $x++;
}

Test2();
Test2();
Test2();
?> 
</p>


<p>casting</p>

<?php
$x = 15;
echo var_dump($x);
$x = (string) $x;
var_dump($x);
?> 


<?php
echo strlen("abcd");
print "<br>";
echo str_word_count("word word");
?>

<br>


<?php
echo strpos("tayyab!", "a");
?> 

<br>

<?php 
echo strtolower($name);
echo strtoupper($name);
?>

<?php
echo "<br>";
$replace = "hello world";

echo str_replace("world","$name",$replace);
echo "<br>";
echo strrev($name);
echo "<br>";
$newname=explode(" ",$name);
print_r ($newname);
echo "<br>";
?>



<?php
echo(min(0, 150, 30, 20, -8, -200) . "<br>");
echo(max(0, 150, 30, 20, -8, -200));
?>


<?php
$ifelse = 13;
echo "<br>";

if ($ifelse > 10) {
  echo "Above 10";
  if ($ifelse > 20) {
    echo " and also above 20";
  } else {
    echo " but not above 20";
  }
}
?>


<?php

echo "<br>";
$members = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

foreach ($members as $x => $y) {
  echo "$x : $y <br>";
}
?>



<?php
echo "<br>";
function familyName($fname) {
  echo "$fname.<br>";
}

familyName("Jani");
familyName("Hege");
familyName("Stale");
familyName("Kai Jim");
familyName("Borge");
?>


<h1>
<?php  
function myFunction() {
  echo "I come from a function!";
}

$myArr = array("Volvo", 15, myFunction());

$myArr[2];
?> 
</h1>


<h3>
<?php  
$cars = array("Volvo", "BMW", "Toyota");
foreach ($cars as &$x) {
  $x = "Ford";
}
//unset($x);
var_dump($cars);
?>  
</h3>


<h1>
  
</h1>
</body>
</html>