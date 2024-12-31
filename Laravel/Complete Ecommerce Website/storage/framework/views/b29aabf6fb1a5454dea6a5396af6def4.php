

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
                    <header class="w3-padding-large w3-large w3-border-bottom" style="font-weight: 500; color:#008cff;">Registration Form</header>

                    <?php if(session('error')): ?>
                    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <?php if(session('message')): ?>
                    <div class="alert alert-success"><?php echo e(session('message')); ?></div>
                    <?php endif; ?>

                    <div class="w3-padding-large">
                        <form method="POST" action="<?php echo e(route('storeuser')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <table>
                                <!-- First Name -->
                                <tr class="tag">
                                    <td><label for="firstName">Enter your First Name</label><span class="error">*</span></td>
                                    <td><input type="text" name="firstName" class="details" value="<?php echo e(old('firstName')); ?>"></td>
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
                                    <td><label for="lastName">Enter your Last Name</label><span class="error">*</span></td>
                                    <td><input type="text" name="lastName" class="details" value="<?php echo e(old('lastName')); ?>"></td>
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
                                    <td><label for="emailID">Enter your Email Id</label><span class="error">*</span></td>
                                    <td><input type="email" name="emailID" class="details" value="<?php echo e(old('emailID')); ?>"></td>
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
                                    <td><label for="password">Enter your Password</label><span class="error">*</span></td>
                                    <td><input type="password" name="password" class="details" value="<?php echo e(old('password')); ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <!-- Phone Number -->
                                <tr class="tag">
                                    <td><label for="phoneNo">Enter Phone Number</label><span class="error">*</span></td>
                                    <td><input type="number" name="phoneNo" class="details" value="<?php echo e(old('phoneNo')); ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['phoneNo'];
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
                                    <td><label for="address">Enter your Address</label><span class="error">*</span></td>
                                    <td><textarea name="address" class="details"><?php echo e(old('address')); ?></textarea></td>
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
                                    <td><label for="country">Select your Country</label><span class="error">*</span></td>
                                    <td>
                                        <select name="country" id="country" class="details">
                                            <option value="">Select Country</option>
                                            <option value="Pakistan" <?php echo e(old('country') == 'Pakistan' ? 'selected' : ''); ?>>Pakistan</option>
                                            <option value="USA" <?php echo e(old('country') == 'USA' ? 'selected' : ''); ?>>USA</option>
                                            <option value="Canada" <?php echo e(old('country') == 'Canada' ? 'selected' : ''); ?>>Canada</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <!-- State -->
                                <tr class="tag">
                                    <td><label for="state">Select your State</label><span class="error">*</span></td>
                                    <td>
                                        <select name="state" id="state" class="details">
                                            <option value="">Select State</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <!-- City -->
                                <tr class="tag">
                                    <td><label for="city">Select your City</label><span class="error">*</span></td>
                                    <td>
                                        <select name="city" id="city" class="details">
                                            <option value="">Select City</option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- Image Upload -->
                                <tr class="tag">
                                    <td><label for="image">Upload Profile Picture</label><span class="error">*</span></td>
                                    <td><input type="file" name="image" class="details" accept="image/*"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td><?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></td>
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
    </div>

    <script>
        // JavaScript to update the state and city dropdown based on selected country and state
        document.getElementById('country').addEventListener('change', function() {
            var country = this.value;
            var stateSelect = document.getElementById('state');
            var citySelect = document.getElementById('city');
            stateSelect.innerHTML = '<option value="">Select State</option>'; // Reset state dropdown
            citySelect.innerHTML = '<option value="">Select City</option>'; // Reset city dropdown

            // Load states based on selected country
            if (country === 'Pakistan') {
                stateSelect.innerHTML += '<option value="Sindh">Sindh</option><option value="Punjab">Punjab</option>';
            } else if (country === 'USA') {
                stateSelect.innerHTML += '<option value="California">California</option><option value="New York">New York</option>';
            } else if (country === 'Canada') {
                stateSelect.innerHTML += '<option value="Ontario">Ontario</option><option value="Quebec">Quebec</option>';
            }
        });

        // JavaScript to update cities based on selected state
        document.getElementById('state').addEventListener('change', function() {
            var state = this.value;
            var citySelect = document.getElementById('city');
            citySelect.innerHTML = '<option value="">Select City</option>'; // Reset city dropdown

            if (state === 'Sindh') {
                citySelect.innerHTML += '<option value="Karachi">Karachi</option><option value="Hyderabad">Hyderabad</option>';
            } else if (state === 'Punjab') {
                citySelect.innerHTML += '<option value="Lahore">Lahore</option><option value="Multan">Multan</option>';
            } else if (state === 'California') {
                citySelect.innerHTML += '<option value="Los Angeles">Los Angeles</option><option value="San Francisco">San Francisco</option>';
            } else if (state === 'New York') {
                citySelect.innerHTML += '<option value="New York City">New York City</option><option value="Buffalo">Buffalo</option>';
            } else if (state === 'Ontario') {
                citySelect.innerHTML += '<option value="Toronto">Toronto</option><option value="Ottawa">Ottawa</option>';
            } else if (state === 'Quebec') {
                citySelect.innerHTML += '<option value="Montreal">Montreal</option><option value="Quebec City">Quebec City</option>';
            }
        });
    </script>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\tayyab\example-app\resources\views/admin/adduser.blade.php ENDPATH**/ ?>