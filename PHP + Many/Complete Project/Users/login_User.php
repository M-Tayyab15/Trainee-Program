<?php
session_start();
if (isset($_SESSION['username1'])) 
{
    header('Location: index_User.php');
    exit;
}
if (isset($_SESSION['username'])) 
{
    header('Location: ../index2.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>W3 User Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="./assets/icons/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/w3pro-4.13.css">
    <link rel="stylesheet" href="./assets/css/w3-theme.css">
    <link rel="stylesheet" href="./assets/css/admin-styles.css">
    <link rel="stylesheet" href="./assets/css/scrollbar.css">
    <style>
        .w3-main {
            min-height: calc(100vh - 110px);
            display: flex;
            flex-direction: column;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="w3-light-grey">


    <div class="w3-main" style="margin-top:54px">
        <div style="padding:16px 32px">
            <div class="w3-padding-32">
                <div class="w3-auto" style="width:380px">
                    <div class="w3-white w3-round w3-margin-bottom w3-border" >
                        <div class="w3-padding-large">
                            <div class="w3-center w3-padding-16">
                                <img src="./assets/admin-logo.png" alt="w3mix" class="w3-image">
                                <p>SIGN IN</p>
                            </div>
                            <?php if (isset($_SESSION['error'])): ?>
                                <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
                                <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>
                            <form action="loginValidation_User.php" method="post">
                                <div class="w3-margin-bottom">
                                    <input type="text" class="w3-input w3-round w3-border" name="username" placeholder="Enter Email">
                                    <?php if (isset($_SESSION['username_error'])): ?>
                                        <p style="color: red;"><?php echo $_SESSION['username_error']; ?></p>
                                        <?php unset($_SESSION['username_error']); ?>
                                    <?php endif; ?>
                                </div>

                                <div class="w3-margin-bottom">
                                    <input type="password" class="w3-input w3-round w3-border" name="password" placeholder="Enter Password">
                                    <?php if (isset($_SESSION['password_error'])): ?>
                                        <p style="color: red;"><?php echo $_SESSION['password_error']; ?></p>
                                        <?php unset($_SESSION['password_error']); ?>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="w3-button w3-round w3-margin-bottom w3-primary w3-block">Sign In</button>
                                <div class="w3-center w3-border-top">
                                <p class="w3-margin"><span class="w3-text-warning">Create an account?</span> <a href="register.php"> Sign up here</a></p>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="w3-padding w3-border-top w3-center w3-white w3-margin-top">
        <div>
        </div>
        <span class="w3-opacity">Powered with <span class="w3-text-red">♥</span> by <a href="https://w3mix.com"
                target="_blank"><strong>W3Mix.com</strong></a>.</span>
    </footer>
    </div>
    </div>
</body>

</html>