<?php
session_start();
include 'connection.php';
include 'validationforUserModal.php'; // Include validation logic

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
$password = ""; // Leave empty to avoid displaying the old password
$picture = $user['picture'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
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
    
    /*function input_data($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }*/
    
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
    
           // include 'add_user.php';
            //header('Location: add_user.php');
           // exit;
        } else {
            echo "<p class='msg' style='font-size: 16px; color:red; text-align:center; margin-top:60px'>You shared Invalid details
                    <br/>Please provide correct data!</p>";
        }
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
    } else {
        
        $sql = "UPDATE tbl_user_info SET password = '$newPassword' WHERE user_id = $userId";
        $conn->query($sql);
    }
}


if (empty($errorMessage)) {
    $sql = "UPDATE tbl_profile SET 
        firstname = '".$_POST["firstName"]."',
        lastname = '".$_POST["lastName"]."',
        phone_number = '".$_POST["phoneNo"]."',
        address = '".$_POST["address"]."',
        country = '".$_POST["country"]."',
        state = '".$_POST["state"]."',
        city = '".$_POST["city"]."',
        age = '".$_POST["age"]."',
        gender = '".$_POST["gender"]."',
        profession = '".$_POST["profession"]."',
        qualification = '".$_POST["qualification"]."',
        institute = '".$_POST["institute"]."',
        comments = '".$_POST["comments"]."'
    WHERE user_id = $userId";
    $conn->query($sql);

    // Redirect to the users page
    header("Location: users.php");
    exit;
}
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php
include 'layout/header.php';
include 'layout/sidebar.php';
?>
<div class="container w3-main" style="padding:70px;">
<?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    <h2>Edit User Details</h2>
    <form action="" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="emailID" value="<?php echo $emailID; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="old_password">Old Password</label>
            <input type="password" class="form-control" id="old_password" name="old_password">
        </div>

        <div class="form-group">
            <label for="new_password">New Password (leave blank to keep current)</label>
            <input type="password" class="form-control" id="new_password" name="new_password">
        </div>

        <div class="form-group">
            <label for="firstname">Name</label>
            <input type="text" class="form-control" id="name" name="firstName" value="<?php echo $firstName; ?>" required>
        </div>

        <div class="form-group">
            <label for="lastname"> LastName</label>
            <input type="text" class="form-control" id="lastname" name="lastName" value="<?php echo $lastName; ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone #</label>
            <input type="text" class="form-control" id="phone" name="phoneNo" value="<?php echo $phoneNo; ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" class="form-control" id="country" name="country" value="<?php echo $country; ?>" required>
        </div>
        <div class="form-group">
            <label for="state">State</label>
            <input type="text" class="form-control" id="state" name="state" value="<?php echo $state; ?>" required>
        </div>

        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" class="form-control" id="age" name="age" value="<?php echo $age; ?>" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <input type="radio" name="gender" value="Male" <?php if ($gender == "Male") echo "checked"; ?>> Male
            <input type="radio" name="gender" value="Female" <?php if ($gender == "Female") echo "checked"; ?>> Female
        </div>

        <div class="form-group">
            <label for="profession">Profession</label>
            <input type="text" class="form-control" id="profession" name="profession" value="<?php echo $profession; ?>" required>
        </div>

        <div class="form-group">
            <label for="qualification">Qualification</label>
            <input type="text" class="form-control" id="qualification" name="qualification" value="<?php echo $Qualification; ?>" required>
        </div>

        <div class="form-group">
            <label for="institute">Institute</label>
            <input type="text" class="form-control" id="institute" name="institute" value="<?php echo $institute; ?>" required>
        </div>

        <div class="form-group">
            <label for="comments">Comments</label>
            <textarea class="form-control" id="comments" name="comments" required><?php echo $comments; ?></textarea>
        </div>

        <div class="form-group">
        <input type="text" class="form-control" id="picture" name="picture" value="<?php echo $picture; ?>" readonly>
        </div>

        <div class="form-group">
        <tr class="tag">
                    <td><label for="profilePicture">Update Profile Picture</label>
                        <span class="error">*</span>
                    </td>
                    <td><input type="file" name="profilePicture" class="details" accept="image/*" ></td>
                </tr>

        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="users.php" class="btn btn-secondary">Go Back</a>
    </form>
</div>
<script src="./assets/plugins/chartjs/Chart.min.js"></script>
<script src="./assets /plugins/chartjs/dashboard.js"></script>
<?php include 'layout/footer.php'; ?>
</body>
</html>