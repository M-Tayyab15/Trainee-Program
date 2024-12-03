<?php
//session_start();

// $firstNameErr = "";
// $lastNameErr = "";
// $emailIDErr = "";
// $phoneNoErr = "";
// $addressErr = "";
// $countryErr = "";
// $stateErr = "";
// $cityErr = "";
// $ageErr = "";
// $genderErr = "";
// $professionErr = "";
// $QualificationErr = "";
// $instituteErr = "";
// $commentsErr = "";

$profilePictureErr = "";
$targetFile = "";


$firstName = "";
$lastName = "";
$emailID = "";
$phoneNo = "";
$address = "";
$country = "";
$state = "";
$city = "";
$age = "";
$gender = "";
$profession = "";
$Qualification = "";
$institute = "";
$comments = "";
$password = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["firstName"])) {
        $firstNameErr = "First Name is required";
    } else {
        $firstName = input_data($_POST["firstName"]);
        if (!preg_match("/^[a-zA-Z]*$/", $firstName)) {
            $firstNameErr =
                "Only alphabets are allowed.";
        }
    }


    if (empty($_POST["lastName"])) {
        $lastNameErr = "Last Name is required";
    } else {
        $lastName = input_data($_POST["lastName"]);
        if (!preg_match("/^[a-zA-Z]*$/", $lastName)) {
            $lastNameErr =
                "Only alphabets are allowed.";
        }
    }

    if (empty($_POST["emailID"])) {
        $emailIDErr = "Email ID is required";
    } else {
        $emailID = input_data($_POST["emailID"]);
    
        if (!filter_var($emailID, FILTER_VALIDATE_EMAIL)) {
            $emailIDErr = "Invalid Email ID format";
        } else {
            $result = $conn->query("SELECT COUNT(*) FROM tbl_user_info WHERE email = '$emailID'");
            $emailExists = $result->fetch_row()[0];
    
            if ($emailExists > 0) {
                $emailIDErr = "User already exists with this email address.";
            }
        }
    }
    


    if (empty($_POST["password"])) {
        $passwordErr = "password is required";
    } else {
        $password = input_data($_POST["password"]);

    }


    if (empty($_POST["phoneNo"])) {
        $phoneNoErr = "Phone Number is required";
    } else {
        $phoneNo = input_data($_POST["phoneNo"]);

        if (!preg_match("/^[0-9]*$/", $phoneNo)) {
            $phoneNoErr = "Only numeric values are allowed!!";
        } elseif (strlen($phoneNo) < 10 || strlen($phoneNo) > 13) {
            $phoneNoErr = " 10-13 digits allowed!";
        }
    }


    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = input_data($_POST["address"]);
    }


    if (empty($_POST["country"])) {
        $countryErr = "Country is required";
    } else {
        $country = input_data($_POST["country"]);
    }


    if (empty($_POST["state"])) {
        $stateErr = "State is required";
    } else {
        $state = input_data($_POST["state"]);
    }


    if (empty($_POST["city"])) {
        $cityErr = "City is required";
    } else {
        $city = input_data($_POST["city"]);
    }


    if (empty($_POST["age"])) {
        $ageErr = "Age is required";
    } else {
        $age = input_data($_POST["age"]);

        if (!preg_match("/^[0-9]*$/", $age)) {
            $ageErr = "Only numeric values are allowed!!";
        }

        if ($age < 0 || $age > 150) {
            $ageErr = "Age Range is from 0-150";
        }
    }


    if (empty($_POST["gender"])) {
        $genderErr = "Please provide your Gender";
    } else {
        $gender = input_data($_POST["gender"]);
    }

    if (empty($_POST["profession"])) {
        $professionErr = "Profession is required";
    } else {
        $profession = input_data($_POST["profession"]);
    }

    if (empty($_POST["Qualification"])) {
        $QualificationErr = "Qualification is required";
    } else {
        $Qualification = input_data($_POST["Qualification"]);
    }

    if (empty($_POST["institute"])) {
        $instituteErr = "Institute is required";
    } else {
        $institute = input_data($_POST["institute"]);
    }

    if (empty($_POST["comments"])) {
        $commentsErr = "Comments are required";
    } else {
        $comments = input_data($_POST["comments"]);
    }

// Handle file upload
if (isset($_FILES["profilePicture"])) {
    $targetDir = "uploadpic/"; 
    $imageFileType = strtolower(pathinfo($_FILES["profilePicture"]["name"], PATHINFO_EXTENSION));


    $count = 1; 
    $targetFile = $targetDir . $count . "_pic." . $imageFileType; 

    $uploadOk = 1;

    // Check file size (limit to 2MB for example)
    if ($_FILES["profilePicture"]["size"] > 2000000) {
        $profilePictureErr = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        $profilePictureErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check for existing files and create a unique file name if necessary
    while (file_exists($targetFile)) {
        $count++;
        $targetFile = $targetDir . $count . "_pic." . $imageFileType; 
    }

    // Attempt to move the uploaded file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile)) {
            
            $_SESSION['profilePicture'] = $targetFile; 
        } else {
            $profilePictureErr = "Sorry, there was an error uploading your file.";
        }
    }
}
}

function input_data($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['submit'])) {

    if (
        empty($firstNameErr) && empty($lastNameErr) &&
        empty($emailIDErr) && empty($phoneNoErr) &&
        empty($addressErr) && empty($countryErr) &&
        empty($stateErr) && empty($cityErr) &&
        empty($ageErr) && empty($genderErr) &&
        empty($professionErr) && empty($QualificationErr) &&
        empty($instituteErr) && empty($commentsErr)
        && empty($passwordErr) && empty($profilePictureErr)
    ) {

        include 'add_user.php';
        //header('Location: add_user.php');
        exit;
    } else {
        echo "<p class='msg' style='font-size: 16px; color:red; text-align:center; margin-top:60px'>You shared Invalid details
                <br/>Please provide correct data!</p>";
    }
}
