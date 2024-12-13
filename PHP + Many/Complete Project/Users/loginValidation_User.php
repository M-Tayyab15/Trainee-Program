<?php
session_start();

// Include the database connection
require_once 'C:\wamp64\www\login-dashboard\connection.php'; // Adjust the path as necessary

// Initialize variables
$username = '';
$password = '';
$username_error = '';
$password_error = '';

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';  

    // Validate email format
    if (empty($username)) {
        $username_error = 'Email is required.';
    } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $username_error = 'Invalid email format.';
    }

    // Validate password
    if (empty($password)) {
        $password_error = 'Password is required.';
    }

    // If there are errors, redirect back with error messages
    if (!empty($username_error) || !empty($password_error)) {
        $_SESSION['username_error'] = $username_error;
        $_SESSION['password_error'] = $password_error;
        header('Location: login_User.php');
        exit;
    }

    // Query the database for the email
    $stmt = $conn->prepare("SELECT user_id, email, password FROM tbl_user_info WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            // Set session variables for the logged-in user
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username1'] = $user['email'];
            $_SESSION['usernameTR'] = explode('@', $user['email'])[0];
            $_SESSION['name'] = $user['name'];

            // Debugging: Output session variable for redirection
            if (isset($_SESSION['redirect_after_login'])) {
                var_dump($_SESSION['redirect_after_login']);  // Debugging line
                $redirect_url = $_SESSION['redirect_after_login'];
                //unset($_SESSION['redirect_after_login']); // Clear after use
                header('Location: ' . $redirect_url);
                exit;
            } else {
                // Default redirection if no referrer page is stored
                header('Location: ../carousel.php');
                exit;
            }
        } else {
            // Invalid password
            $_SESSION['error'] = 'Invalid username or password';
            header('Location: login_User.php');
            exit;
        }
    } else {
        // User not found
        $_SESSION['error'] = 'Invalid username or password';
        header('Location: login_User.php');
        exit;
    }
}
