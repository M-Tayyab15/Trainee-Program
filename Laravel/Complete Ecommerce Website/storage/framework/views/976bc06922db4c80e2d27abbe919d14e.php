

<?php $__env->startSection('content'); ?>


<head>
    <style>
        .centerForm {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .w3-padding-large {
            padding: 30px;
        }

        input.details,
        textarea.details,
        select.details {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input.details:focus,
        textarea.details:focus,
        select.details:focus {
            border-color: #008cff;
        }

        .btn {
            background-color: #008cff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #006bb3;
        }

        .error {
            color: red;
        }

        select.details {
            height: 40px;
        }
    </style>
</head>

<body>
    <div class="w3-main" style="margin-top:54px">
        <div style="padding:16px 32px">
            <div class="w3-row-padding w3-stretch">
                <div class="w3-white w3-round w3-margin-bottom w3-border centerForm">
                    <header class="w3-padding-large w3-large w3-border-bottom" style="font-weight: 500; color:#008cff;">Edit User</header>

                    <?php if(session('error')): ?>
                    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <div class="w3-padding-large">
                        <form method="POST" action="<?php echo e(route('updateuser', $user->id)); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?> <!-- This ensures the form sends a PATCH request -->
                            <table>
                                <!-- First Name -->
                                <tr class="tag">
                                    <td><label for="firstName">First Name</label><span class="error">*</span></td>
                                    <td><input type="text" name="firstName" class="details" value="<?php echo e(old('firstName', $user->firstName)); ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['firstName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <!-- Last Name -->
                                <tr class="tag">
                                    <td><label for="lastName">Last Name</label><span class="error">*</span></td>
                                    <td><input type="text" name="lastName" class="details" value="<?php echo e(old('lastName', $user->lastName)); ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['lastName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <!-- Email -->
                                <tr class="tag">
                                    <td><label for="emailID">Email</label><span class="error">*</span></td>
                                    <td><input type="email" name="emailID" class="details" value="<?php echo e(old('emailID', $user->email)); ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['emailID'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <!-- Password -->
                                <tr class="tag">
                                    <td><label for="oldPassword">Old Password</label><span class="error">*</span></td>
                                    <td><input type="password" name="oldPassword" class="details" value="<?php echo e(old('oldPassword')); ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['oldPassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <tr class="tag">
                                    <td><label for="newPassword">New Password</label><span class="error">*</span></td>
                                    <td><input type="password" name="newPassword" class="details" value="<?php echo e(old('newPassword')); ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['newPassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <!-- Address -->
                                <tr class="tag">
                                    <td><label for="address">Address</label><span class="error">*</span></td>
                                    <td><textarea name="address" class="details"><?php echo e(old('address', $user->profile->address ?? 'NA')); ?></textarea></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <!-- Country -->
                                <tr class="tag">
                                    <td><label for="country">Country</label><span class="error">*</span></td>
                                    <td>
                                        <select name="country" class="details" id="country">
                                            <option value="Pakistan" <?php echo e(old('country', $user->profile->country) == 'Pakistan' ? 'selected' : ''); ?>>Pakistan</option>
                                            <option value="USA" <?php echo e(old('country', $user->profile->country) == 'USA' ? 'selected' : ''); ?>>USA</option>
                                            <option value="Canada" <?php echo e(old('country', $user->profile->country) == 'Canada' ? 'selected' : ''); ?>>Canada</option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- State -->
                                <tr class="tag">
                                    <td><label for="state">State</label><span class="error">*</span></td>
                                    <td>
                                        <select name="state" class="details" id="state">
                                            <option value="Sindh" <?php echo e(old('state', $user->profile->state) == 'Sindh' ? 'selected' : ''); ?>>Sindh</option>
                                            <option value="Punjab" <?php echo e(old('state', $user->profile->state) == 'Punjab' ? 'selected' : ''); ?>>Punjab</option>
                                            <option value="California" <?php echo e(old('state', $user->profile->state) == 'California' ? 'selected' : ''); ?>>California</option>
                                            <option value="Texas" <?php echo e(old('state', $user->profile->state) == 'Texas' ? 'selected' : ''); ?>>Texas</option>
                                            <option value="Ontario" <?php echo e(old('state', $user->profile->state) == 'Ontario' ? 'selected' : ''); ?>>Ontario</option>
                                            <option value="Quebec" <?php echo e(old('state', $user->profile->state) == 'Quebec' ? 'selected' : ''); ?>>Quebec</option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- City -->
                                <tr class="tag">
                                    <td><label for="city">City</label><span class="error">*</span></td>
                                    <td>
                                        <select name="city" class="details" id="city">
                                            <?php if($user->profile->state == 'Sindh'): ?>
                                            <option value="Karachi" <?php echo e(old('city', $user->profile->city) == 'Karachi' ? 'selected' : ''); ?>>Karachi</option>
                                            <option value="Hyderabad" <?php echo e(old('city', $user->profile->city) == 'Hyderabad' ? 'selected' : ''); ?>>Hyderabad</option>
                                            <?php elseif($user->profile->state == 'Punjab'): ?>
                                            <option value="Lahore" <?php echo e(old('city', $user->profile->city) == 'Lahore' ? 'selected' : ''); ?>>Lahore</option>
                                            <option value="Faisalabad" <?php echo e(old('city', $user->profile->city) == 'Faisalabad' ? 'selected' : ''); ?>>Faisalabad</option>
                                            <?php elseif($user->profile->state == 'California'): ?>
                                            <option value="Los Angeles" <?php echo e(old('city', $user->profile->city) == 'Los Angeles' ? 'selected' : ''); ?>>Los Angeles</option>
                                            <option value="San Francisco" <?php echo e(old('city', $user->profile->city) == 'San Francisco' ? 'selected' : ''); ?>>San Francisco</option>
                                            <?php elseif($user->profile->state == 'Texas'): ?>
                                            <option value="Houston" <?php echo e(old('city', $user->profile->city) == 'Houston' ? 'selected' : ''); ?>>Houston</option>
                                            <option value="Dallas" <?php echo e(old('city', $user->profile->city) == 'Dallas' ? 'selected' : ''); ?>>Dallas</option>
                                            <?php elseif($user->profile->state == 'Ontario'): ?>
                                            <option value="Toronto" <?php echo e(old('city', $user->profile->city) == 'Toronto' ? 'selected' : ''); ?>>Toronto</option>
                                            <option value="Ottawa" <?php echo e(old('city', $user->profile->city) == 'Ottawa' ? 'selected' : ''); ?>>Ottawa</option>
                                            <?php elseif($user->profile->state == 'Quebec'): ?>
                                            <option value="Montreal" <?php echo e(old('city', $user->profile->city) == 'Montreal' ? 'selected' : ''); ?>>Montreal</option>
                                            <option value="Quebec City" <?php echo e(old('city', $user->profile->city) == 'Quebec City' ? 'selected' : ''); ?>>Quebec City</option>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                </tr>


                                <!-- Image Upload -->
                                <tr class="tag">
                                    <td><label for="image">Profile Image</label></td>
                                    <td><input type="file" name="image" class="details"></td>
                                </tr>

                                <tr class="tag">
                                    <td>
                                        <input type="submit" name="submit" value="Update" class="btn">
                                    <td></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script>
    // When country changes, clear state and city
    document.getElementById('country').addEventListener('change', function() {
        var country = this.value;

        // Clear state and city dropdowns
        var stateSelect = document.getElementById('state');
        var citySelect = document.getElementById('city');

        stateSelect.innerHTML = ''; // Clear existing options
        citySelect.innerHTML = ''; // Clear existing options

        if (country === 'Pakistan') {
            // Add Pakistan states
            stateSelect.innerHTML = `
                <option value="Sindh">Sindh</option>
                <option value="Punjab">Punjab</option>
            `;
        } else if (country === 'USA') {
            // Add USA states
            stateSelect.innerHTML = `
                <option value="California">California</option>
                <option value="Texas">Texas</option>
            `;
        } else if (country === 'Canada') {
            // Add Canada states
            stateSelect.innerHTML = `
                <option value="Ontario">Ontario</option>
                <option value="Quebec">Quebec</option>
            `;
        }

        // After the country changes, reset the city dropdown
        citySelect.innerHTML = '<option value="">Select City</option>';
    });

    // When state changes, update the cities dropdown
    document.getElementById('state').addEventListener('change', function() {
        var state = this.value;
        var citySelect = document.getElementById('city');

        // Clear the city dropdown
        citySelect.innerHTML = '';

        if (state === 'Sindh') {
            citySelect.innerHTML = `
                <option value="Karachi">Karachi</option>
                <option value="Hyderabad">Hyderabad</option>
            `;
        } else if (state === 'Punjab') {
            citySelect.innerHTML = `
                <option value="Lahore">Lahore</option>
                <option value="Faisalabad">Faisalabad</option>
            `;
        } else if (state === 'California') {
            citySelect.innerHTML = `
                <option value="Los Angeles">Los Angeles</option>
                <option value="San Francisco">San Francisco</option>
            `;
        } else if (state === 'Texas') {
            citySelect.innerHTML = `
                <option value="Houston">Houston</option>
                <option value="Dallas">Dallas</option>
            `;
        } else if (state === 'Ontario') {
            citySelect.innerHTML = `
                <option value="Toronto">Toronto</option>
                <option value="Ottawa">Ottawa</option>
            `;
        } else if (state === 'Quebec') {
            citySelect.innerHTML = `
                <option value="Montreal">Montreal</option>
                <option value="Quebec City">Quebec City</option>
            `;
        }
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/admin/updateuser.blade.php ENDPATH**/ ?>