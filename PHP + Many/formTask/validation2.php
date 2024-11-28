<?php
session_start();

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
        }
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
    ) {

        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['emailID'] = $emailID;
        $_SESSION['phoneNo'] = $phoneNo;
        $_SESSION['address'] = $address;
        $_SESSION['country'] = $country;
        $_SESSION['state'] = $state;
        $_SESSION['city'] = $city;
        $_SESSION['age'] = $age;
        $_SESSION['gender'] = $gender;
        $_SESSION['profession'] = $profession;
        $_SESSION['Qualification'] = $Qualification;
        $_SESSION['institute'] = $institute;
        $_SESSION['comments'] = $comments;


        include 'emailFunction.php';


        $recipientEmails = [
            'muhammadtayyabafc@gmail.com'
        ];

        $bodyContent = '
        <!DOCTYPE html>
        <html>
        <head>
        <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
      }
                .container {
                  max-width: 600px;
                  margin: auto;
                  background: white;
                  padding: 20px;
                  border-radius: 8px;
                  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  }
                  h2 {
                    text-align: center;
                    color: #333;
                    }
                    
                    .table-message {
                      margin-bottom: 20px;
                      padding: 10px;
                      background-color: #e7f3fe;
                      border-left: 6px solid #2196F3;
                      }
                      table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                        }
                        th, td {
                    text-align: left;
                    padding: 12px;
                    border: 1px solid #ddd;
                    }
                    th {
                      background-color: #4CAF50;
                    color: white;
                    }
                tr:nth-child(even) {
                  background-color: #f9f9f9;
                }
                tr:hover 
                {
                  background-color: #f1f1f1;
                  }
                  
                .contact-message 
                    {
                    margin-top: 20px;
                    text-align: center;
                    padding: 15px;
                    background-color: #f9f9f9;
                    border: 1px solid #d1e7dd;
                    border-radius: 5px;
                    color: #333;
                    }
                    
                .contact-message p 
                    {
                    margin: 0;
                    line-height: 1.5;
                    }

                .submit-link {
                  text-align: center;
                  margin-top: 20px;
                  }
                .submit-link a {
                    padding: 10px 15px;
                    background-color: #4CAF50;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    }
                .submit-link a:hover 
                {
                      background-color: #45a049;
                      }
            </style>
        </head>
<body>
  <div class="container">
  <h2>User Information</h2>
  <div class="table-message">This email is regarding the form you submitted. Please review the details below:</div>
  <table>
  <tr><th>Field</th><th>Value</th></tr>
  <tr><td>First Name</td><td>' . $firstName . '</td></tr>
  <tr><td>Last Name</td><td>' . $lastName . '</td></tr>
  <tr><td>Email ID</td><td>' . $emailID . '</td></tr>
  <tr><td>Phone Number</td><td>' . $phoneNo . '</td></tr>
  <tr><td>Address</td><td>' . $address . '</td></tr>
  <tr><td>Country</td><td>' . $country . '</td></tr>
  <tr><td>State</td><td>' . $state . '</td></tr>
  <tr><td>City</td><td>' . $city . '</td></tr>
  <tr><td>Age</td><td>' . $age . '</td></tr>
  <tr><td>Gender</td><td>' . $gender . '</td></tr>
  <tr><td>Profession</td><td>' . $profession . '</td></tr>
  <tr><td>Qualification</td><td>' . $Qualification . '</td></tr>
  <tr><td>Institute</td><td>' . $institute . '</td></tr>
  <tr><td>Comments</td><td>' . $comments . '</td></tr>
  </table>
  <div class="contact-message">
  <p>If you have any questions or issues regarding your submission, please feel free to reach out to us.</p>
  <p>Our team is here to assist you, and we strive to respond to all inquiries within 24 hours.</p>
  <p>Your satisfaction is important to us, and we appreciate your feedback!</p>
  </div>
  <div class="submit-link">
  <a href="http://localhost/formTask/index2.php">Submit Another Form</a>
  </div>
  </div>
  </body>
        </html>
        ';

        foreach ($recipientEmails as $email) {
            $emailParams = [
                'sender' => [
                    'email' => 'muhammadtayyabafc@gmail.com',
                    'name' => 'Tayyab Mansoor',
                    'password' => 'xchq kylr nvhs zbzh'
                ],
                'recipient' => [
                    'email' => $email,
                    'name' => $_SESSION['firstName']
                ],
                'subject' => 'Registration Form',
                'body' => $bodyContent,
            ];

            sendEmail($emailParams);
        }


        header('Location: succcess2.php');
        exit;
    } else {
        echo "<p class='msg' style='font-size: 16px; color:red;'>You shared Invalid details
                <br/>Please provide correct data!</p>";
    }
}
