<?php
session_start();

$username_db = 'tayyab@test.com';
$password_db = 'P@ssword123';

$username = $_POST['username'];
$password = $_POST['password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  $password = isset($_POST['password']) ? trim($_POST['password']) : '';  
  $username_error = '';
  $password_error = '';
  
  if (empty($username)) {
    $username_error = 'Email is required.';
  } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
    $username_error = 'Invalid email format.';
  }
  
  if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
    $password_error = '<h5 style="color:red">PASSWORD REQUIREMENTS NOT MET!</h3>
    <p style="color: darkred">*Password must be at least 8 characters, contain at least one lowercase letter, uppercase letter, number and special character</p>';
  }
  
  if (!empty($username_error) || !empty($password_error)) {
    $_SESSION['username_error'] = $username_error;
    $_SESSION['password_error'] = $password_error;
    header('Location: login2.php'); 
    exit;
  }
  
  if ($username == $username_db && $password == $password_db) {
    $username_trimmed = explode('@', $username)[0]; 
    $_SESSION['username'] = $username;
    $_SESSION['usernameTR'] = $username_trimmed;
    header('Location: index2.php');
    exit;
  } else {
    $error = 'Invalid username or password';
    $_SESSION['error'] = $error;
    header('Location: login2.php');
    exit;
  }
}
?>