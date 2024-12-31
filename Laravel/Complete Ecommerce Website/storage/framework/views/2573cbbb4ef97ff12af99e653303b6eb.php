<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>W3 Admin Dashboard</title>

  <!-- External CSS -->
  <link rel="stylesheet" href="login-dashboard/assets/css/fontCss.css">
  <link rel="stylesheet" href="./assets/icons/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./assets/css/w3pro-4.13.css">
  <link rel="stylesheet" href="./assets/css/w3-theme.css">
  <link rel="stylesheet" href="./assets/css/admin-styles.css">
  <link rel="stylesheet" href="./assets/css/scrollbar.css">

  <!-- JS Libraries -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <style>
    .fixed-footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      height: 50px;
      border-top: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }

    .w3-dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 120px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
      left: 13px;
    }

    .w3-dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .w3-dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .w3-dropdown-hover:hover .w3-dropdown-content {
      display: block;
    }

    .w3-dropdown-hover:hover {
      background-color: white;
    }
  </style>
</head>

<body class="w3-light-grey">

  <!-- Sidebar Start -->
  <nav id="sidebar" class="w3-sidebar w3-top w3-bottom w3-collapse w3-white w3-border-right w3-border-top scrollbar" style="z-index:3;width:230px;height:auto;margin-top:54px;border-color:rgba(0, 0, 0, .1)!important" id="mySidebar">
    <div class="w3-bar-item w3-border-bottom w3-hide-large" style="padding:6px 0">
      <label for="sidebar-control" class="w3-left w3-button w3-large w3-opacity-min" style="background:white!important"><i class="fa fa-bars"></i></label>
      <h5 class="" style="line-height:1; margin:0!important; font-weight:300">
        <a href="./index2.php" class="w3-button" style="background:white!important">
          <img src="./assets/admin-logo.png" alt="w3 mix" class="w3-image"> &nbsp; W3Admin </a>
      </h5>
    </div>
    <div class="w3-bar-block">
      <span class="w3-bar-item w3-padding w3-small w3-opacity" style="margin-top:8px"> MAIN NAVIGATION </span>
      <a href="./index2.php" class="w3-bar-item w3-button w3-padding-large w3-hover-text-primary">
        <i class="fa fa-fw fa-bar-chart"></i>&nbsp; Dashboard </a>
      <a href="./fileUpload.php" class="w3-bar-item w3-button w3-padding-large w3-hover-text-primary">
        <i class="fa fa-fw fa-file-pdf-o"></i>&nbsp; File Upload</a>
      <a href="./users.php" class="w3-bar-item w3-button w3-padding-large w3-hover-text-primary">
        <i class="fa fa-fw fa-users"></i>&nbsp; Manage Users</a>
      <a href="./product.php" class="w3-bar-item w3-button w3-padding-large w3-hover-text-primary">
        <i class="fa fa-fw fa-shopping-cart"></i>&nbsp; Products</a>
      <a href="./orders.php" class="w3-bar-item w3-button w3-padding-large w3-hover-text-primary">
        <i class="fa fa-fw fa-shopping-cart"></i>&nbsp; Orders</a>
    </div>
  </nav>
  <!-- Sidebar End -->

  <!-- Main Content Start -->
  <div class="container-fluid" style="margin-left: 230px; padding-top: 10px;">

    <!-- Header Start -->
    <div class="w3-top w3-card" style="height:54px">
      <div class="w3-flex-bar w3-theme w3-left-align">
        <div class="admin-logo w3-bar-item w3-hide-medium w3-hide-small">
          <h5 class="" style="line-height:1; margin:0!important; font-weight:300">
            <a href="./index2.php" class="w3-button w3-bold">
              <img src="./assets/admin-logo.png" alt="w3mix" class="w3-image" width="26"> &nbsp; W3Admin </a>
          </h5>
        </div>
        <label for="sidebar-control" class="w3-button w3-large w3-opacity-min"><i class="fa fa-bars"></i></label>
        <div class="w3-right">
          <?php if(session('username')): ?>
            <i class="fa fa-user-circle fa-lg"></i>
            <div class="w3-dropdown-hover">
              <button class="w3-button  w3-center w3-text-white w3-primary" style="margin: 0px 10px;">
                <div style="display: flex; flex-direction: column; align-items: center;">
                  <p style="margin: 0; font-size: 14px;"><?php echo e(session('usernameTR')); ?></p>
                  <p style="margin: 0; font-size: 12px; color: black;"><?php echo e(session('username')); ?></p>
                </div>
              </button>
              <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="<?php echo e(route('logout')); ?>" class="w3-bar-item w3-button">Logout</a>
              </div>
            </div>
          <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="w3-button w3-small w3-margin-left">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Main Content -->
    <div class="row">
      <div class="col-md-12 mt-5">
        <?php echo $__env->yieldContent('content'); ?>
      </div>
    </div>
  </div>
  <!-- Main Content End -->

  <!-- Footer Start -->
  <div class="row justify-content-center text-center mt-3">
    <div class="col-md-12">
      <footer class="w3-padding w3-border-top w3-center w3-white w3-margin-top fixed-footer">
        <span class="w3-opacity">Powered with <span class="w3-text-red">♥</span> by <a href="https://w3mix.com" target="_blank"><strong>W3Mix.com</strong></a>.</span>
      </footer>
    </div>
  </div>
  <!-- Footer End -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>
<?php /**PATH F:\tayyab\example-app\resources\views//app.blade.php ENDPATH**/ ?>