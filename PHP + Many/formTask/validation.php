

<?php
$firstNameErr = "";
$lastNameErr = "";
$emailIDErr = "";
$phoneNoErr = "";
$addressErr = "";
$countryErr = "";
$stateErr = "";
$cityErr = "";
$ageErr = "";
$genderErr = "";
$professionErr = "";
$QualificationErr = "";
$instituteErr = "";
$commentsErr = "";


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

// Input fields validation  
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validating the User Name 
    if (empty($_POST["userName"])) {
        $userNameErr = "User Name is required";
    } else {
        $userName = input_data($_POST["userName"]);
        // To check that User Name only contains alphabets, numbers, and underscores 
        if (!preg_match("/^[a-zA-Z0-9_]*$/", $userName)) {
            $userNameErr = 
              "Only alphabets, numbers, and underscores are allowed for User Name";
        }
    }

    // Validating the User EmailID ID  
    if (empty($_POST["emailID"])) {
        $emailIDErr = "Email ID is required";
    } else {
        $emailID = input_data($_POST["emailID"]);
        // To check that the e-mail address is well-formed  
        if (!filter_var($emailID, FILTER_VALIDATE_EMAIL)) {
            $emailIDErr = "Invalid Email ID format";
        }
    }

    // Validating the User Phone Number 
    if (empty($_POST["phoneNo"])) {
        $phoneNoErr = "Phone Number is required";
    } else {
        $phoneNo = input_data($_POST["phoneNo"]);
        // To check that Phone No is well-formed  
        if (!preg_match("/^[0-9]*$/", $phoneNo)) {
            $phoneNoErr = "Only numeric values are allowed!!";
        }
        // To check that Phone No length should not be less and greator than 10  
        elseif (strlen($phoneNo) != 10) {
            $phoneNoErr = "Please provide a phone number of 10 digits!!";
        }
    }

    // Validating the User Website URL    
    if (empty($_POST["website"])) {
        $website = "";
    } else {
        $website = input_data($_POST["website"]);
        // To check that URL address syntax is valid  
        if (!preg_match(
"/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", 
                  $website
            )) {
            $websiteErr = "You entered an INVALID URL";
        }
    }

    // Checking if user has shared his gender
    if (empty($_POST["gender"])) {
        $genderErr = "Please provide your Gender";
    } else {
        $gender = input_data($_POST["gender"]);
    }

    // Checking if user has agreed to the terms and conditions  
    if (!isset($_POST['tc'])) {
        $tcErr = "Please accept our terms & conditions.";
    } else {
        $tc = input_data($_POST["tc"]);
    }
}

// For handling whitespaces and special characters in the data
function input_data($data)
{
    // trim() is used to remove any trailing whitespace
    $data = trim($data);
    // htmlspecialchars() is used to convert 
      // special characters into their HTML entities
    // Example - "&" -> "&amp"
    $data = htmlspecialchars($data);
    return $data;
}
?>
