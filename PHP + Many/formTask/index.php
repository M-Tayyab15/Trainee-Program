<!-- file - index.php -->

<!DOCTYPE html>
<html>

<head>
    <title>PHP Form Validation</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php require "validation.php" ?>

    <p class="msg">A Simple Registration Form ?</p>
    <span class="error">(*) indicates required field</span>



    <form method="post" class="container" role="form" 
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <table>
            <tr class="tag">
                <td><label for="firstName">Enter your First Name</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="firstName" class="details"></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $firstNameErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="lastName">Enter your Last Name</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="lastName" class="details"></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $lastNameErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="emailID">Enter your Email Id</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="emailID" class="details"></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $emailIDErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="phoneNo">Enter your Phone Number</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="phoneNo" class="details"></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $phoneNoErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="address">Enter your Address</label>
                    <span class="error">*</span>
                </td>
                <td><textarea name="address" class="details"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $addressErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="country">Select your Country</label>
                    <span class="error">*</span>
                </td>
                <td>
                    <select name="country" id="country" class="details">
                        <option value="">Select Country</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="USA">USA</option>
                        <option value="Canada">Canada</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $countryErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="state">Select your State</label>
                    <span class="error">*</span>
                </td>
                <td>
                    <select name="state" id="state" class="details">
                        <option value="">Select State</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $stateErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="city">Select your City</label>
                    <span class="error">*</span>
                </td>
                <td>
                    <select name="city" id="city" class="details">
                        <option value="">Select City</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $cityErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="age">Enter your Age</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="age" class="details"></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $ageErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="gender">Enter your Gender</label>
                    <span class="error">*</span>
                </td>
                <td>
                    <input type="radio" name="gender" value="male"> Male
                    <input type="radio" name="gender" value="female"> Female
                </td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $genderErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="profession">Enter your Profession</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="profession" class="details"></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $professionErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="Qualification">Enter your Qualification</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="Qualification" class="details"></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $QualificationErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="institute">Enter your Institute</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="institute" class="details"></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $instituteErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="comments">Enter your Comments</label>
                    <span class="error">*</span>
                </td>
                <td><textarea name="comments" class="details"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php echo $commentsErr; ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><input type="submit" name="submit" value="Submit" class="btn"></td>
                <td></td>
            </tr>
        </table>
    </form>

    <?php
    
    if (isset ($_POST['submit'])) {
        
        if (        $firstNameErr == "" && $lastNameErr == "" &&
        $emailIDErr == "" && $phoneNoErr == "" &&
        $addressErr == "" && $countryErr == "" &&
        $stateErr == "" && $cityErr == "" &&
        $ageErr == "" && $genderErr == "" && $professionErr == "" &&
        $QualificationErr == "" && $instituteErr == "" &&
        $commentsErr == "") {
            echo "<p class='msg'>You have been sucessfully registered?</p>";
            echo "<h3>Your Details are :</h3>";
            echo "<p class='info'>firstName : " . $firstName . "</p>";
            echo "<p class='info'>EmailID ID : " . $emailID . "</p>";
            echo "<p class='info'>Phone Number : " . $phoneNo . "</p>";
            echo "<p class='info'>Gender : " . $gender . "</p>";
            echo "<p class='info'>city : " . $city . "</p>";
            echo "<p class='info'>country : " . $country . "</p>";
            echo "<p class='info'>state : " . $state . "</p>";
        } else {
            echo "<p class='msg'>You shared Invalid details
                    <br/>Please provide correct data!</p>";
        }
    }
    ?>

</body>

</html>
