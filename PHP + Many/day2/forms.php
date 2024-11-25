<html>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Name: <input type="text" name="fname">
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = htmlspecialchars($_REQUEST['fname']);
    if (empty($name)) {
        echo "Name is empty";
    } else {
        echo $name;
    }
}
?>


<form action="test.php" method="POST">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
First Name: <input type="text" name="fname">
<input type="submit">
</form>



<form action="test_get.php" method="GET">
    <h1>get method</h1>
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
First Name: <input type="text" name="fname">
<input type="submit">
</form>


<form action="<?php echo htmlspecialchars($_SERVER["test.php"]);?>" method="post">
Name: <input type="text" name="name1">
E-mail: <input type="text" name="email1">
Website: <input type="text" name="website1">
Comment: <textarea name="comment1" rows="5" cols="40"></textarea>
<input type="radio" name="gender" value="female">Female
<input type="radio" name="gender" value="male">Male
<input type="submit">

</form>

</body>
</html>
