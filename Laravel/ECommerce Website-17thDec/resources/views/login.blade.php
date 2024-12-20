<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/w3pro-4.13.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/w3-theme.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/admin-styles.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/scrollbar.css') }}">



<div class="w3-main" style="margin-top:54px">
    <div style="padding:16px 32px">
        <div class="w3-padding-32">
            <div class="w3-auto" style="width:380px">
                <div class="w3-white w3-round w3-margin-bottom w3-border">
                    <div class="w3-padding-large">
                        <div class="w3-center w3-padding-16">
                            <img src="{{ asset('assets/admin-logo.png') }}" alt="w3mix" class="w3-image">
                            <p>SIGN IN</p>
                        </div>

                        <!-- Display error message if any -->
                        @if (session('error'))
                        <p class="text-danger">{{ session('error') }}</p>
                        @endif

                        <!-- Form Start -->
                        <form action="{{ route('authenticate') }}" method="POST">
                            @csrf

                            <!-- Email Address -->
                            <div class="w3-margin-bottom">
                                <input type="email" name="email" class="w3-input w3-round w3-border @error('email') is-invalid @enderror" placeholder="Enter Email" value="{{ old('email', request()->cookie('email') ?? '') }}">
                                @error('email')
                                <span class="w3-text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="w3-margin-bottom">
                                <input type="password" name="password" class="w3-input w3-round w3-border @error('password') is-invalid @enderror" placeholder="Enter Password">
                                @error('password')
                                <span class="w3-text-red">{{ $message }}</span>
                                @enderror
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
                                <p class="w3-margin"><span class="w3-text-warning">Create an account?</span> <a href="{{ route('register') }}"> Sign up here</a></p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>