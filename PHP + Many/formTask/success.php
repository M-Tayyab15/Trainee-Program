<?php
session_start(); 

echo "<h3>Your Details are :</h3>";
echo "<p class='info'>First Name : " . $_SESSION['firstName'] . "</p>";
echo "<p class='info'>Last Name : " . $_SESSION['lastName'] . "</p>";
echo "<p class='info'>Email ID : " . $_SESSION['emailID'] . "</p>";
echo "<p class='info'>Phone Number : " . $_SESSION['phoneNo'] . "</p>";
echo "<p class='info'>Address : " . $_SESSION['address'] . "</p>";
echo "<p class='info'>Country : " . $_SESSION['country'] . "</p>";
echo "<p class='info'>State : " . $_SESSION['state'] . "</p>";
echo "<p class='info'>City : " . $_SESSION['city'] . "</p>";
echo "<p class='info'>Age : " . $_SESSION['age'] . "</p>";
echo "<p class='info'>Gender : " . $_SESSION['gender'] . "</p>";
echo "<p class='info'>Profession : " . $_SESSION['profession'] . "</p>";
echo "<p class='info'>Qualification : " . $_SESSION['Qualification'] . "</p>";
echo "<p class='info'>Institute : " . $_SESSION['institute'] . "</p>";
echo "<p class='info'>Comments : " . $_SESSION['comments'] . "</p>";
?>