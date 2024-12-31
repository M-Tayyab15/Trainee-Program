<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/w3pro-4.13.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/w3-theme.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin-styles.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/scrollbar.css')); ?>">



<div class="w3-main" style="margin-top:54px">
    <div style="padding:16px 32px">
        <div class="w3-padding-32">
            <div class="w3-auto" style="width:380px">
                <div class="w3-white w3-round w3-margin-bottom w3-border">
                    <div class="w3-padding-large">
                        <div class="w3-center w3-padding-16">
                            <img src="<?php echo e(asset('assets/admin-logo.png')); ?>" alt="w3mix" class="w3-image">
                            <p>SIGN IN</p>
                        </div>

                        <!-- Display error message if any -->
                        <?php if(session('error')): ?>
                        <p class="text-danger"><?php echo e(session('error')); ?></p>
                        <?php endif; ?>

                        <!-- Form Start -->
                        <form action="<?php echo e(route('authenticate')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <!-- Email Address -->
                            <div class="w3-margin-bottom">
                                <input type="email" name="email" class="w3-input w3-round w3-border <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter Email" value="<?php echo e(old('email', request()->cookie('email') ?? '')); ?>">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="w3-text-red"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Password -->
                            <div class="w3-margin-bottom">
                                <input type="password" name="password" class="w3-input w3-round w3-border <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter Password">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="w3-text-red"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Remember Me Checkbox -->
                            <div class="w3-margin-bottom">
                                <label>
                                    <input type="checkbox" name="remember" class="w3-check"> Remember Me
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w3-button w3-round w3-margin-bottom w3-primary w3-block">Sign In</button>

                            <!-- Sign Up Link -->
                            <div class="w3-center w3-border-top">
                                <p class="w3-margin"><span class="w3-text-warning">Create an account?</span> <a href="<?php echo e(route('register')); ?>"> Sign up here</a></p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH F:\tayyab\example-app\resources\views/login.blade.php ENDPATH**/ ?>