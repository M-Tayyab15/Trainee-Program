<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>W3 Admin Dashboard</title>
  <link rel="stylesheet" href="login-dashboard\assets\css\fontCss.css">
  <link rel="stylesheet" href="./assets/icons/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./assets/css/w3pro-4.13.css">
  <link rel="stylesheet" href="./assets/css/w3-theme.css">
  <link rel="stylesheet" href="./assets/css/admin-styles.css">
  <link rel="stylesheet" href="./assets/css/scrollbar.css">
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
  <input id="sidebar-control" type="checkbox" class="w3-hide">
  <div id="app">
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
          <?php if (isset($_SESSION['username'])) : ?>
            <i class="fa fa-user-circle fa-lg"></i>
            <div class="w3-dropdown-hover">
              <button class="w3-button  w3-center w3-text-white w3-primary" style="margin: 0px 10px;">
                <div style="display: flex; flex-direction: column; align-items: center;">
                  <p style="margin: 0; font-size: 14px;"><?php echo $_SESSION['usernameTR']; ?></p>
                  <p style="margin: 0; font-size: 12px; color: black;"><?php echo $_SESSION['username']; ?></p>
                </div>
              </button>
              <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
              </div>
            </div>
          <?php else : ?>
            <a href="login2.php" class="w3-button w3-small w3-margin-left">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </div>