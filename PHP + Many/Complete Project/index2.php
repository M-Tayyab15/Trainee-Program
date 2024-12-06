<?php
session_start();
if (isset($_SESSION['username1'])) {
  header('Location: Users/index_User.php');
  exit;
}
if (!isset($_SESSION['username'])) 
{
  header('Location: login2.php');
  exit;
}

?>
<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>
<div class="w3-main" style="margin-top:54px">
  <div style="padding:16px 32px">
    <div class="w3-white w3-round w3-margin-bottom w3-border" style="">
      <div class="w3-row">
        <div class="w3-col  w3-container">
          <div style="text-align: center;">
            <h1>
              Welcome to Dashboard Dear
            </h1>
            <h1> <?php
                   if (isset($_SESSION['username'])) {
                     
                     echo '<p style=" padding: 8px; color: blue; text-transform: capitalize;">'  . $_SESSION['usernameTR'] . '</p>';
                   } else {
                     
                     echo '<p style=" padding: 8px; color: royalblue;"> User</p>';
                   }
                   ?> </h1>
          </div>
        
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/plugins/chartjs/Chart.min.js"></script>
  <script src="./assets/plugins/chartjs/dashboard.js"></script>
  <?php include 'layout/footer.php'; ?>
</body>
</html>