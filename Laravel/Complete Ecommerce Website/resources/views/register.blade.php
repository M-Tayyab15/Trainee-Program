

<head>

    <!-- Add W3.CSS and your custom CSS files here -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/w3pro-4.13.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/w3-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/scrollbar.css') }}">
</head>


<body>
    
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="w3-padding-32">
                <div class="w3-auto" style="width:380px">
                    <div class="w3-white w3-round w3-margin-bottom w3-border">
                        <div class="w3-padding-large">
                            <div class="w3-center w3-padding-16">
                                <img src="{{ asset('assets/admin-logo.png') }}" alt="w3mix" class="w3-image">
                                <p>SIGN UP</p>
                            </div>
                            
                            <!-- Success and Error Messages -->
                            @if (session('successMsg'))
                            <div class="w3-text-green">{{ session('successMsg') }}</div>
                            @endif
                            
                            <!-- Form Start -->
                            <form action="{{ route('store') }}" method="POST">
                                @csrf
                                
                                <div class="w3-margin-bottom">
                                    <input type="text" name="name" class="w3-input w3-round w3-border @error('name') is-invalid @enderror" placeholder="Enter Your Name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="w3-text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <!-- Email -->
                                <div class="w3-margin-bottom">
                                    <input type="email" name="email" class="w3-input w3-round w3-border @error('email') is-invalid @enderror" placeholder="Enter Your Email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="w3-text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <!-- Password -->
                                <div class="w3-margin-bottom">
                                    <input type="password" name="password" class="w3-input w3-round w3-border @error('password') is-invalid @enderror" placeholder="Choose Password">
                                    @error('password')
                                    <span class="w3-text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <!-- Confirm Password -->
                                <div class="w3-margin-bottom">
                                    <input type="password" name="password_confirmation" class="w3-input w3-round w3-border" placeholder="Confirm Password">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w3-button w3-round w3-margin-bottom w3-primary w3-block">Sign Up</button>
                            </form>
                        </div>
                        
                        <!-- Sign In Link -->
                        <div class="w3-center w3-border-top">
                            <p class="w3-margin"><span class="w3-text-warning">Already have an account?</span> <a href="{{ route('login') }}"> Sign in here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>

    
</body>