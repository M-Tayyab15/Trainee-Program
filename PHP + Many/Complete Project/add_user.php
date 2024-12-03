<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['emailID'];
    $password = $_POST['password'];
    $phoneNo = $_POST['phoneNo'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $profession = $_POST['profession'];
    $qualification = $_POST['Qualification'];
    $institute = $_POST['institute'];
    $comments = $_POST['comments'];
    $time = time();
    
    $queryUser = "INSERT INTO tbl_user_info (email, password, created_on,status) VALUES ('$email', '$password', $time, '1')";
    
    if ($conn->query($queryUser) === TRUE) {
        $userId = $conn->insert_id;
        $profilepic = $userId . '_pic';
        

        $queryProfile = "INSERT INTO tbl_profile (user_id, firstname, lastname, phone_number, address, country, state, city, age, gender, profession, qualification, institute, comments, picture) 
                         VALUES ($userId, '$firstName', '$lastName', '$phoneNo', '$address', '$country', '$state', '$city', '$age', '$gender', '$profession', '$qualification', '$institute', '$comments', '$profilepic')";
        
        if ($conn->query($queryProfile) === TRUE) {
            $_SESSION['message'] = "New user added successfully"; 
        } else {
            $_SESSION['error'] = "Error inserting into profile: " . $conn->error; 
        }
    } else {
        $_SESSION['error'] = "Error inserting into user info: " . $conn->error; 
    }

    $conn->close();
    header('Location: users.php'); 
    exit;
}
?>
