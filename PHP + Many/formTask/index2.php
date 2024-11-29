<!DOCTYPE html>
<html>

<head>
    <title>PHP Form Validation</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php require "validation2.php" ?>

    <p class="msg">A Simple Registration Form</p>
    <span class="error">(*) indicates required field</span>

    <form method="post" class="container" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr class="tag">
                <td><label for="firstName">Enter your First Name</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="firstName" class="details" value="<?php echo $firstName; ?>" required></td>
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

            <tr class="tag">
                <td><label for="lastName">Enter your Last Name</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="lastName" class="details" value="<?php echo $lastName; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php
                        if(isset($lastNameErr) && !empty($lastNameErr))
                        {
                            echo $lastNameErr;
                        }
                        ?>
                    </span></td>
            </tr>

            <tr class="tag">
                <td><label for="emailID">Enter your Email Id</label>
                    <span class="error">*</span>
                </td>
                <td><input type="email" name="emailID" class="details" value="<?php echo $emailID; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <span class="error">
                        <?php
                        if(isset($emailIDErr) && !empty($emailIDErr))
                        {
                            echo $emailIDErr; 
                        }
                         ?>
                    </span>
                </td>
            </tr>

            <tr class="tag">
                <td><label for="phoneNo">Enter your Phone Number</label>
                    <span class="error">*</span>
                </td>
                <td><input type="number" name="phoneNo" class="details" value="<?php echo $phoneNo; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <span class="error">
                        <?php 
                        if (isset($phoneNoErr) && !empty($phoneNoErr))
                        {
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
                <td><textarea name="address" class="details" required><?php echo $address; ?></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><span class="error">
                        <?php
                        if(isset($addressErr) && !empty($addressErr))
                        {
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
                    <select name="country" id="country" class="details" required>
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
                    if(isset($countryErr) && !empty($countryErr))
                    {
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
                    <select name="state" id="state" class="details" required>
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
                    if(isset($stateErr) && !empty($stateErr))
                    {
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
                    <select name="city" id="city" class="details" required>
                        <option value="">Select City</option>
                        <?php
                        if (isset($country) && $country == "Pakistan" && isset($state)) {
                            if ($state == "Sindh") {
                                echo '<option value="Karachi" ' . (isset($city) && $city == "Karachi" ? "selected" : "") . '>Karachi</option>';
                                echo '<option value="Hyderabad" ' . (isset($city) && $city == "Hyderabad" ? "selected" : "") . '>Hyderabad</option>';
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
                <td><span class="error">
                        <?php 
                        if(isset($cityErr) && !empty($cityErr))
                        {
                            echo $cityErr; 
                        }
                        ?>
                    </span>
                </td>
            </tr>

            <tr class="tag">
                <td><label for="age">Enter your Age</label>
                    <span class="error">*</span>
                </td>
                <td><input type="number" name="age" class="details" value="<?php echo $age; ?>" required></td>
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
                    <input type="radio" name="gender" <?php if (isset($gender) && $gender == "Male") echo "checked"; ?> value="Male" required> Male
                    <input type="radio" name="gender" <?php if (isset($gender) && $gender == "Female") echo "checked"; ?> value="Female"> Female
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <span class="error">
                        <?php
                        if(isset($genderErr) && !empty($genderErr)) 
                        echo $genderErr; 
                        ?>
                    </span>
                </td>
            </tr>

            <tr class="tag">
                <td><label for="profession">Enter your Profession</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="profession" class="details" value="<?php echo $profession; ?>" required></td>
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
                <td><input type="text" name="Qualification" class="details" value="<?php echo $Qualification; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <span class="error">
                        <?php 
                        if(isset($QualificationErr) && !empty($QualificationErr))
                        echo $QualificationErr; 
                        ?>
                    </span>
                </td>
            </tr>

            <tr class="tag">
                <td><label for="institute">Enter your Institute</label>
                    <span class="error">*</span>
                </td>
                <td><input type="text" name="institute" class="details" value="<?php echo $institute; ?>" required></td>
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
                <td><textarea name="comments" class="details" required><?php echo $comments; ?></textarea></td>
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
                <td><input type="submit" name="submit" value="Submit" class="btn"></td>
                <td></td>
            </tr>
        </table>
    </form>

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
                    $('#city').html('<option value="">Select City</option><option value="Karachi">Karachi</option><option value="Hyderabad">Hyderabad</option>');
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

</body>

</html>