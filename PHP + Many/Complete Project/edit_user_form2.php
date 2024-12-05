<?php
session_start();
include 'connection.php';

// Check if the user ID is set in the URL
if (!isset($_GET['id'])) {
    header('Location: users.php'); // Redirect if no ID is provided
    exit;
}

// Sanitize the user ID
$userId = (int)$_GET['id'];

// Fetch the user's current details
$sql = "SELECT 
    p.profile_id,
    p.firstname,
    p.lastname,
    p.phone_number,
    p.address,
    p.country,
    p.state,
    p.city,
    p.age,
    p.gender,
    p.profession,
    p.qualification,
    p.institute,
    p.comments,
    u.user_id,
    u.email,
    u.password,
    p.picture
FROM 
    tbl_profile p
RIGHT JOIN 
    tbl_user_info u ON p.user_id = u.user_id
WHERE 
    u.user_id = $userId AND u.status = 1";

$result = $conn->query($sql);

// Check if a user was found
if ($result->num_rows === 0) {
    header('Location: users.php'); // Redirect if no user found
    exit;
}

$user = $result->fetch_assoc();

// Initialize variables for form fields
$firstName = $user['firstname'];
$lastName = $user['lastname'];
$emailID = $user['email'];
$phoneNo = $user['phone_number'];
$address = $user['address'];
$country = $user['country'];
$state = $user['state'];
$city = $user['city'];
$age = $user['age'];
$gender = $user['gender'];
$profession = $user['profession'];
$Qualification = $user['qualification'];
$institute = $user['institute'];
$comments = $user['comments'];

// Initialize error messages
$firstNameErr = $lastNameErr = $emailIDErr = $phoneNoErr = $addressErr = $countryErr = $stateErr = $cityErr = $ageErr = $genderErr = $professionErr = $QualificationErr = $instituteErr = $commentsErr = $passwordErr = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate fields
    $valid = true; // Flag to track overall validation

    if (empty($_POST["firstName"])) {
        $firstNameErr = "First Name is required";
        $valid = false;
    } else {
        $firstName = input_data($_POST["firstName"]);
        if (!preg_match("/^[a-zA-Z]*$/", $firstName)) {
            $firstNameErr = "Only alphabets are allowed.";
            $valid = false;
        }
    }

    if (empty($_POST["lastName"])) {
        $lastNameErr = "Last Name is required";
        $valid = false;
    } else {
        $lastName = input_data($_POST["lastName"]);
        if (!preg_match("/^[a-zA-Z]*$/", $lastName)) {
            $lastNameErr = "Only alphabets are allowed.";
            $valid = false;
        }
    }

    if (empty($_POST["emailID"])) {
        $emailIDErr = "Email ID is required";
        $valid = false;
    } else {
        $emailID = input_data($_POST["emailID"]);
        if (!filter_var($emailID, FILTER_VALIDATE_EMAIL)) {
            $emailIDErr = "Invalid Email ID format";
            $valid = false;
        }
    }

    if (empty($_POST["phoneNo"])) {
        $phoneNoErr = "Phone Number is required";
        $valid = false;
    } else {
        $phoneNo = input_data($_POST["phoneNo"]);
        if (!preg_match("/^[0-9]*$/", $phoneNo)) {
            $phoneNoErr = "Only numeric values are allowed!!";
            $valid = false;
        } elseif (strlen($phoneNo) < 10 || strlen($phoneNo) > 13) {
            $phoneNoErr = "10-13 digits allowed!";
            $valid = false;
        }
    }

    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
        $valid = false;
    } else {
        $address = input_data($_POST["address"]);
    }

    if (empty($_POST["country"])) {
        $countryErr = "Country is required";
        $valid = false;
    } else {
        $country = input_data($_POST["country"]);
    }

    if (empty($_POST["state"])) {
        $stateErr = "State is required";
        $valid = false;
    } else {
        $state = input_data($_POST["state"]);
    }

    if (empty($_POST["city"])) {
        $cityErr = "City is required";
        $valid = false;
    } else {
        $city = input_data($_POST["city"]);
    }

    if (empty($_POST["age"])) {
        $ageErr = "Age is required";
        $valid = false;
    } else {
        $age = input_data($_POST["age"]);
        if (!preg_match("/^[0-9]*$/", $age)) {
            $ageErr = "Only numeric values are allowed!!";
            $valid = false;
        } elseif ($age < 18 || $age > 100) {
            $ageErr = "Age should be between 18 and 100!!";
            $valid = false;
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
        $valid = false;
    } else {
        $gender = input_data($_POST["gender"]);
    }

    if (empty($_POST["profession"])) {
        $professionErr = "Profession is required";
        $valid = false;
    } else {
        $profession = input_data($_POST["profession"]);
    }

    if (empty($_POST["Qualification"])) {
        $QualificationErr = "Qualification is required";
        $valid = false;
    } else {
        $Qualification = input_data($_POST["Qualification"]);
    }

    if (empty($_POST["institute"])) {
        $instituteErr = "Institute is required";
        $valid = false;
    } else {
        $institute = input_data($_POST["institute"]);
    }

    if (empty($_POST["comments"])) {
        $commentsErr = "Comments are required";
        $valid = false;
    } else {
        $comments = input_data($_POST["comments"]);
    }

    // Check if the old password is correct if the user wants to change the password
    if (!empty($_POST["new_password"])) {
        $oldPassword = $_POST["old_password"];
        $newPassword = $_POST["new_password"];

        // Verify the old password
        $sql = "SELECT password FROM tbl_user_info WHERE user_id = $userId";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if ($row["password"] !== $oldPassword) {
            $errorMessage = "Old password is incorrect.";
            $valid = false;
        } else {
            // Update the password
            $sql = "UPDATE tbl_user_info SET password = '$newPassword' WHERE user_id = $userId";
            $conn->query($sql);
        }
    }

    // If there are no errors, update the user details in the database
    if ($valid) {
        $sql = "UPDATE tbl_profile SET 
            firstname = '" . $_POST["firstName"] . "',
            lastname = '" . $_POST["lastName"] . "',
            phone_number = '" . $_POST["phoneNo"] . "',
            address = '" . $_POST["address"] . "',
            country = '" . $_POST["country"] . "',
            state = '" . $_POST["state"] . "',
            city = '" . $_POST["city"] . "',
            age = '" . $_POST["age"] . "',
            gender = '" . $_POST["gender"] . "',
            profession = '" . $_POST["profession"] . "',
            qualification = '" . $_POST["Qualification"] . "',
            institute = '" . $_POST["institute"] . "',
            comments = '" . $_POST["comments"] . "'
        WHERE user_id = $userId";
        $conn->query($sql);

        // Redirect to the users page
        header("Location: users.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset=" UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>W3Admin Dashboard - Free Dashboard for HTML5/w3css by W3MIX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="./assets/icons/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets /css/w3pro-4.13.css">
    <link rel="stylesheet" href="./assets/css/w3-theme.css">
    <link rel="stylesheet" href="./assets/css/admin-styles.css">
    <link rel="stylesheet" href="./assets/css/scrollbar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .error {
            color: red;
            margin-bottom: 30px;
        }

        .msg {
            color: brown;
            margin: 20px 0px 10px 0px;
            font-size: 25px;
            font-weight: bold;
        }

        .tags {
            margin: 0px 0px 20px 0px;
        }

        input {
            border-radius: 10px;
        }

        .details {
            width: 100%;
            height: 30px;
        }

        .info {
            margin: 2px 0;
        }

        .btn {
            margin-top: 20px;
            width: 120px;
            height: 30px;
            background-color: #008cff;
            color: white;
        }

        .centerForm {
            width: fit-content;
            margin: auto;
        }

        label {
            color: #008cff;
        }
    </style>
</head>

<body class="w3-light-grey">
    <?php include 'Layout/header.php' ?>
    <?php include 'Layout/sidebar.php' ?>
    <div class="w3-main" style="margin-top:54px">
        <div style="padding:16px 32px">
            <div class="w3-row-padding w3-stretch">

                <div class="w3-white w3-round w3-margin-bottom w3-border centerForm">
                    <header class="w3-padding-large w3-large w3-border-bottom" style="font-weight: 500; color:#008cff;">Registration Form</header>
                    <?php

                    if (isset($_SESSION['error'])) {
                        echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                        unset($_SESSION['error']);
                    }


                    if (isset($_SESSION['message'])) {
                        echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                        unset($_SESSION['message']);
                    }
                    ?>
                    <div class="w3-padding-large">
                        <form method="post" class="container" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <table>
                                <tr class="tag">
                                    <td><label for="firstName">Enter your First Name</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="text" name="firstName" class="details" value="<?php echo $firstName; ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="error">
                                            <?php
                                            if (isset($firstNameErr) && !empty($firstNameErr))
                                                echo $firstNameErr;
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <!-- Rest of your form fields and error messages here -->
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="error">
                                            <?php
                                            if (isset($firstNameErr) && !empty($firstNameErr))
                                                echo $firstNameErr;
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="lastName">Enter your Last Name</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="text" name="lastName" class="details" value="<?php echo $lastName; ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><span class="error">
                                            <?php
                                            if (isset($lastNameErr) && !empty($lastNameErr)) {
                                                echo $lastNameErr;
                                            }
                                            ?>
                                        </span></td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="emailID">Enter your Email Id</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="email" name="emailID" class="details" value="<?php echo $emailID; ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="error">
                                            <?php
                                            if (isset($emailIDErr) && !empty($emailIDErr)) {
                                                echo $emailIDErr;
                                            }
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="old_password">Enter your Old Password</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="password" name="old_password" class="details"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="error">
                                            <?php
                                            if (isset($passwordErr) && !empty($passwordErr)) {
                                                echo $passwordErr;
                                            }
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="new_password">Enter your New Password</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="password" name="new_password" class="details"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="error">
                                            <?php
                                            if (isset($passwordErr) && !empty($passwordErr)) {
                                                echo $passwordErr;
                                            }
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="phoneNo">Enter Phone Number</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="number" name="phoneNo" class="details" value="<?php echo $phoneNo; ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="error">
                                            <?php
                                            if (isset($phoneNoErr) && !empty($phoneNoErr)) {
                                                echo $phoneNoErr;
                                            }
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="address">Enter your Address</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><textarea name="address" class="details"><?php echo $address; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><span class="error">
                                            <?php
                                            if (isset($addressErr) && !empty($addressErr)) {
                                                echo $addressErr;
                                            }
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="country">Select your Country</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td>
                                        <select name="country" id="country" class="details">
                                            <option value="">Select Country</option>
                                            <option value="Pakistan" <?php if (isset($country) && $country == "Pakistan") echo "selected"; ?>>Pakistan</option>
                                            <option value="USA" <?php if (isset($country) && $country == "USA") echo "selected"; ?>>USA</option>
                                            <option value="Canada" <?php if (isset($country) && $country == "Canada") echo "selected"; ?>>Canada</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><span class="error">
                                            <?php
                                            if (isset($countryErr) && !empty($countryErr)) {
                                                echo $countryErr;
                                            }
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="state">Select your State</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td>
                                        <select name="state" id="state" class="details">
                                            <option value="">Select State</option>
                                            <?php
                                            if (isset($country) && $country == "Pakistan") {
                                                echo '<option value="Sindh" ' . (isset($state) && $state == "Sindh" ? "selected" : "") . '>Sindh</option>';
                                                echo '<option value="Punjab" ' . (isset($state) && $state == "Punjab" ? "selected" : "") . '>Punjab</option>';
                                                echo '<option value="KPK" ' . (isset($state) && $state == "KPK" ? "selected" : "") . '>KPK</option>';
                                                echo '<option value="Balochistan" ' . (isset($state) && $state == "Balochistan" ? "selected" : "") . '>Balochistan</option>';
                                            } elseif (isset($country) && $country == "USA") {
                                                echo '<option value="California" ' . (isset($state) && $state == "California" ? "selected" : "") . '>California</option>';
                                                echo '<option value="New York" ' . (isset($state) && $state == "New York" ? "selected" : "") . '>New York</option>';
                                            } elseif (isset($country) && $country == "Canada") {
                                                echo '<option value="Ontario" ' . (isset($state) && $state == "Ontario" ? "selected" : "") . '>Ontario</option>';
                                                echo '<option value="Quebec" ' . (isset($state) && $state == "Quebec" ? "selected" : "") . '>Quebec</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><span class="error">
                                            <?php
                                            if (isset($stateErr) && !empty($stateErr)) {
                                                echo $stateErr;
                                            }
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="city">Select your City</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td>
                                        <select name="city" id="city" class="details">
                                            <option value="">Select City</option>
                                            <?php
                                            if (isset($country) && $country == "Pakistan" && isset($state)) {
                                                if ($state == "Sindh") {
                                                    echo '<option value="Karachi" ' . (isset($city) && $city == "Karachi" ? "selected" : "") . '>Karachi</option>';
                                                    echo '<option value="Hyderabad" ' . (isset($city) && $city == "Hyderabad" ? "selected" : "") . '>Hy derabad</option>';
                                                } elseif ($state == "Punjab") {
                                                    echo '<option value="Lahore" ' . (isset($city) && $city == "Lahore" ? "selected" : "") . '>Lahore</option>';
                                                    echo '<option value="Islamabad" ' . (isset($city) && $city == "Islamabad" ? "selected" : "") . '>Islamabad</option>';
                                                } elseif ($state == "KPK") {
                                                    echo '<option value="Peshawar" ' . (isset($city) && $city == "Peshawar" ? "selected" : "") . '>Peshawar</option>';
                                                    echo '<option value="Mansehra " ' . (isset($city) && $city == "Mansehra" ? "selected" : "") . '>Mansehra</option>';
                                                } elseif ($state == "Balochistan") {
                                                    echo '<option value="Quetta" ' . (isset($city) && $city == "Quetta" ? "selected" : "") . '>Quetta</option>';
                                                    echo '<option value="Gwader" ' . (isset($city) && $city == "Gwader" ? "selected" : "") . '>Gwader</option>';
                                                }
                                            } elseif (isset($country) && $country == "USA" && isset($state)) {
                                                if ($state == "California") {
                                                    echo '<option value="Los Angeles" ' . (isset($city) && $city == "Los Angeles" ? "selected" : "") . '>Los Angeles</option>';
                                                    echo '<option value="San Francisco" ' . (isset($city) && $city == "San Francisco" ? "selected" : "") . '>San Francisco</option>';
                                                } elseif ($state == "New York") {
                                                    echo '<option value="New York City" ' . (isset($city) && $city == "New York City" ? "selected" : "") . '>New York City</option>';
                                                    echo '<option value="Buffalo" ' . (isset($city) && $city == "Buffalo" ? "selected" : "") . '>Buffalo</option>';
                                                }
                                            } elseif (isset($country) && $country == "Canada" && isset($state)) {
                                                if ($state == "Ontario") {
                                                    echo '<option value="Toronto" ' . (isset($city) && $city == "Toronto" ? "selected" : "") . '>Toronto</option>';
                                                    echo '<option value="Ottawa" ' . (isset($city) && $city == "Ottawa" ? "selected" : "") . '>Ottawa</option>';
                                                } elseif ($state == "Quebec") {
                                                    echo '<option value="Montreal" ' . (isset($city) && $city == "Montreal" ? "selected" : "") . '>Montreal</option>';
                                                    echo '<option value="Quebec City" ' . (isset($city) && $city == "Quebec City" ? "selected" : "") . '>Quebec City</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><span class="error"> <?php if (isset($cityErr) && !empty($cityErr)) {
                                                                    echo $cityErr;
                                                                } ?> </span> </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="age">Enter your Age</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="number" name="age" class="details" value="<?php echo $age; ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><span class="error">
                                            <?php
                                            if (isset($ageErr) && !empty($ageErr)) {
                                                echo $ageErr;
                                            }
                                            ?>
                                        </span></td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="gender">Enter your Gender</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td>
                                        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "Male") echo "checked"; ?> value="Male"> Male
                                        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "Female") echo "checked"; ?> value="Female"> Female
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="error">
                                            <?php
                                            if (isset($genderErr) && !empty($genderErr))
                                                echo $genderErr;
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="profession">Enter your Profession</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="text" name="profession" class="details" value="<?php echo $profession; ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><span class="error">
                                            <?php
                                            if (isset($professionErr) && !empty($professionErr)) {
                                                echo $professionErr;
                                            }
                                            ?>
                                        </span></td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="Qualification">Enter your Qualification</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="text" name="Qualification" class="details" value="<?php echo $Qualification; ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="error">
                                            <?php
                                            if (isset($QualificationErr) && !empty($QualificationErr))
                                                echo $QualificationErr;
                                            ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="institute">Enter your Institute</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="text" name="institute" class="details" value="<?php echo $institute; ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><span class="error">
                                            <?php
                                            if (isset($instituteErr) && !empty($instituteErr)) {
                                                echo $instituteErr;
                                            }
                                            ?>
                                        </span></td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="comments">Enter your Comments</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><textarea name="comments" class="details"><?php echo $comments; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><span class="error">
                                            <?php if (isset($commentsErr) && !empty($commentsErr)) {
                                                echo $commentsErr;
                                            }
                                            ?>

                                        </span></td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="profilePicture">Upload Profile Picture</label>
                                        <span class="error">*</span>
                                    </td>
                                    <td><input type="file" name="profilePicture" class="details" accept="image/*"></td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="error">
                                            <?php if (isset($profilePictureErr) && !empty($profilePictureErr)) echo $profilePictureErr; ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="tag">
                                    <td><input type="submit" name="submit" value="Submit" class="btn"></td>
                                    <td></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#country').on('change', function() {
                    var country = $(this).val();
                    if (country == 'Pakistan') {
                        $('#state').html('<option value="">Select State</option><option value="Sindh">Sindh</option><option value="Punjab">Punjab</option><option value="KPK">KPK</option><option value="Balochistan">Balochistan</option>');
                        $('#city').html('<option value="">Select City</option>');
                    } else if (country == 'USA') {
                        $('#state').html('<option value="">Select State</option><option value="California">California</option><option value="New York">New York</option>');
                        $('#city').html('<option value="">Select City</option>');
                    } else if (country == 'Canada') {
                        $('#state').html('<option value="">Select State</option><option value="Ontario">Ontario</option><option value="Quebec">Quebec</option>');
                        $('#city').html('<option value="">Select City</option>');
                    }
                });

                $('#state').on('change', function() {
                    var state = $(this).val();
                    var country = $('#country').val();
                    if (country == 'Pakistan' && state == 'Sindh') {
                        $('#city').html('<option value ="">Select City</option><option value="Karachi">Karachi</option><option value="Hyderabad">Hyderabad</option>');
                    } else if (country == 'Pakistan' && state == 'Punjab') {
                        $('#city').html('<option value="">Select City</option><option value="Lahore">Lahore</option><option value="Islamabad">Islamabad</option>');
                    } else if (country == 'Pakistan' && state == 'KPK') {
                        $('#city').html('<option value="">Select City</option><option value="Peshawar">Peshawar</option><option value="Mansehra">Mansehra</option>');
                    } else if (country == 'Pakistan' && state == 'Balochistan') {
                        $('#city').html('<option value="">Select City</option><option value="Quetta">Quetta</option><option value="Gwader">Gwader</option>');
                    } else if (country == 'USA' && state == 'California') {
                        $('#city').html('<option value="">Select City</option><option value="Los Angeles">Los Angeles</option><option value="San Francisco">San Francisco</option>');
                    } else if (country == 'USA' && state == 'New York') {
                        $('#city').html('<option value="">Select City</option><option value="New York City">New York City</option><option value="Buffalo">Buffalo</option>');
                    } else if (country == 'Canada' && state == 'Ontario') {
                        $('#city').html('<option value="">Select City</option><option value="Toronto">Toronto</option><option value="Ottawa">Ottawa</option>');
                    } else if (country == 'Canada' && state == 'Quebec') {
                        $('#city').html('<option value="">Select City</option><option value="Montreal">Montreal</option><option value="Quebec City">Quebec City</option>');
                    }
                });
            });
        </script>

        <script src="./assets/plugins/chartjs/Chart.min.js"></script>
        <script src="./assets/plugins/chartjs/dashboard.js"></script>
    </div>

    <?php include 'Layout/footer.php' ?>
</body>

</html>