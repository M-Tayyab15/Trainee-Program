<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We'll be back soon!</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #00bcd4, #8e24aa);
            color: #fff;
            text-align: center;
            overflow: hidden;
            flex-direction: column;
        }

        h1 {
            font-size: 50px;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 5px;
            animation: fadeIn 1s ease-in-out;
        }

        p {
            font-size: 22px;
            margin-bottom: 30px;
            font-weight: 300;
            animation: fadeIn 2s ease-in-out;
        }

        /* Spinning settings wheel */
        .wheel-container {
            position: relative;
            display: inline-block;
            margin-bottom: 40px;
        }

        .wheel {
            border: 12px solid #fff;
            border-top: 12px solid #ff4081;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 2s linear infinite;
        }

        .wheel:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 12px;
            height: 12px;
            background-color: #ff4081;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        /* Animation for fading text */
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Animation for spinning */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Button style (optional, if you want a retry button) */
        .retry-btn {
            background-color: #ff4081;
            color: #fff;
            font-size: 18px;
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            margin-top: 20px;
            transition: all 0.3s;
        }

        .retry-btn:hover {
            background-color: #d500f9;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Spinning Wheel -->
    <div class="wheel-container">
        <div class="wheel"></div>
    </div>

    <!-- Main Title -->
    <h1>We'll Be Back Soon!</h1>

    <!-- Subtitle Text -->
    <p>We're performing some maintenance, but we'll be back shortly.</p>

    <!-- Optional Retry Button -->
    <a href="/" class="retry-btn">Try Again</a>
</body>
</html>
