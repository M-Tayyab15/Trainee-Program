<?php
session_start();

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html>
  
<head>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
    }

    h3 {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }
    
    td {
      text-align: left;
      padding: 8px;
    }
    
    tr td:first-child {
      background-color: lightblue;
      border: 1px white solid;
      width: 25%;
    }
    
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    
    th {
      background-color: #4CAF50;
      color: white;
    }
    
    #emailAlert {
      display: block;
    }
  </style>
</head>

<body>
  
<div id="emailAlert" style="font-size:large; font-weight:bold">
  <?php echo htmlspecialchars($message); ?>
  </div>

  <script>
    setTimeout(function() {
      document.getElementById("emailAlert").style.display = "none";
    }, 3000);
  </script>


  <div class="container">
    <h3>Your Information</h3>
    <table>
      <tr>
        <td>First Name</td>
        <td><?php echo $_SESSION['firstName']; ?></td>
      </tr>
      <tr>
        <td>Last Name</td>
        <td><?php echo $_SESSION['lastName']; ?></td>
      </tr>
      <tr>
        <td>Email ID</td>
        <td><?php echo $_SESSION['emailID']; ?></td>
      </tr>
      <tr>
        <td>Phone Number</td>
        <td><?php echo $_SESSION['phoneNo']; ?></td>
      </tr>
      <tr>
        <td>Address</td>
        <td><?php echo $_SESSION['address']; ?></td>
      </tr>
      <tr>
        <td>Country</td>
        <td><?php echo $_SESSION['country']; ?></td>
      </tr>
      <tr>
        <td>State</td>
        <td><?php echo $_SESSION['state']; ?></td>
      </tr>
      <tr>
        <td>City</td>
        <td><?php echo $_SESSION['city']; ?></td>
      </tr>
      <tr>
        <td>Age</td>
        <td><?php echo $_SESSION['age']; ?></td>
      </tr>
      <tr>
        <td>Gender</td>
        <td><?php echo $_SESSION['gender']; ?></td>
      </tr>
      <tr>
        <td>Profession</td>
        <td><?php echo $_SESSION['profession']; ?></td>
      </tr>
      <tr>
        <td>Qualification</td>
        <td><?php echo $_SESSION['Qualification']; ?></td>
      </tr>
      <tr>
        <td>Institute</td>
        <td><?php echo $_SESSION['institute']; ?></td>
      </tr>
      <tr>
        <td>Comments</td>
        <td><?php echo $_SESSION['comments']; ?></td>
      </tr>
    </table>
  </div>
</body>
</html>