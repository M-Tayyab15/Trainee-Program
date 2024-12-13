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
    <title>W3Admin Dashboard - Free Dashboard for HTML5/w3css by W3MIX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="./assets/icons/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/w3pro-4.13.css">
    <link rel="stylesheet" href="./assets/css/w3-theme.css">
    <link rel="stylesheet" href="./assets/css/admin-styles.css">
    <link rel="stylesheet" href="./assets/css/scrollbar.css">
</head>

<body class="w3-light-grey">
    <?php
    include 'C:\wamp64\www\login-dashboard\connection.php';

    // Initialize variables and error messages
    $firstName = $lastName = $email = $password = "";
    $firstNameErr = $lastNameErr = $emailErr = $passwordErr = "";
    $successMsg = "";
    $time = time();


    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate first name
        if (empty($_POST["first_name"])) {
            $firstNameErr = "First name is required";
        } else {
            $firstName = htmlspecialchars(trim($_POST["first_name"]));
        }

        // Validate last name
        if (empty($_POST["last_name"])) {
            $lastNameErr = "Last name is required";
        } else {
            $lastName = htmlspecialchars(trim($_POST["last_name"]));
        }

        // Validate email
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            $email = htmlspecialchars(trim($_POST["email"]));
        }

        // Validate password
        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $_POST["password"])) {
            $passwordErr = "Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, one digit, and one special character.";
        } else {
            $password = htmlspecialchars(trim($_POST["password"]));
        }

        // If no errors, store user data in database
        if (empty($firstNameErr) && empty($lastNameErr) && empty($emailErr) && empty($passwordErr)) {
            // Hash the password before saving it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql1 = "INSERT INTO tbl_user_info (email, password, created_on, status) VALUES ('$email', '$password', $time, '1')";
            if ($conn->query($sql1) === TRUE) {
                $userId = $conn->insert_id;
                $sql2 = "INSERT INTO tbl_profile (user_id, firstname, lastname) VALUES ($userId, '$firstName', '$lastName')";
            
                if ($conn->query($sql2) === TRUE) {
                    $successMsg = "Registration successful! You can now log in.";
                } else {
                    $errorMsg = "Error with second query: " . $sql2 . "<br>" . $conn->error;
                    echo $errorMsg; // Debugging output
                }
            } else {
                $errorMsg = "Error with first query: " . $sql1 . "<br>" . $conn->error;
                echo $errorMsg; // Debugging output
            }
            
        }
    }
    ?>


    <div id="app">
        <div class="" style="margin-top:54px">
            <div style="padding:16px 32px">
                <div class="w3-padding-32">
                    <div class="w3-auto" style="width:380px">
                        <div class="w3-white w3-round w3-margin-bottom w3-border">
                            <div class="w3-padding-large">
                                <div class="w3-center w3-padding-16">
                                    <img src="./assets/admin-logo.png" alt="w3mix" class="w3-image">
                                    <p>SIGN UP</p>
                                </div>

                                <?php if ($successMsg): ?>
                                    <div class="w3-text-green"><?php echo $successMsg; ?></div>
                                <?php endif; ?>

                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="w3-margin-bottom">
                                        <input type="text" name="first_name" class="w3-input w3-round w3-border" placeholder="Enter Your First Name" value="<?php echo $firstName; ?>">
                                        <span class="w3-text-red"><?php echo $firstNameErr; ?></span>
                                    </div>
                                    <div class="w3-margin-bottom">
                                        <input type="text" name="last_name" class="w3-input w3-round w3-border" placeholder="Enter Your Last Name" value="<?php echo $lastName; ?>">
                                        <span class="w3-text-red"><?php echo $lastNameErr; ?></span>
                                    </div>
                                    <div class="w3-margin-bottom">
                                        <input type="text" name="email" class="w3-input w3-round w3-border" placeholder="Enter Your Email" value="<?php echo $email; ?>">
                                        <span class="w3-text-red"><?php echo $emailErr; ?></span>
                                    </div>
                                    <div class="w3-margin-bottom">
                                        <input type="password" name="password" class="w3-input w3-round w3-border" placeholder="Choose Password">
                                        <span class="w3-text-red"><?php echo $passwordErr; ?></span>
                                    </div>
                                    <button type="submit" class="w3-button w3-round w3-margin-bottom w3-primary w3-block">Sign Up</button>
                                </form>
                            </div>
                            <div class="w3-center w3-border-top">
                                <p class="w3-margin"><span class="w3-text-warning">Already have an account?</span> <a href="login_User.php"> Sign in here</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="position: relative; bottom:-60px;">
        <?php include 'Layout/footer.php'; ?>
    </div>
</body>

</html>