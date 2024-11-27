<?php

  $username = 'tayyab';
  $password = 'xolva';
  $dashboard_url = 'dashboard.html';


  $username_input = $_POST['username'];
  $password_input = $_POST['password'];

  if ($username_input === $username && $password_input === $password) {
  
    header('Location: ' . $dashboard_url);
    exit;
  } else {
    // Display error message
    $error_message = 'Invalid ID or Password';
  }
?>

<!-- Display error message if credentials are invalid -->
<p id="error-message"><?= $error_message ?></p>