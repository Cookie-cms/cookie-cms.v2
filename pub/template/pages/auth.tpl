<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Projectname }} &#x2022 auth</title>
    <link rel="icon" type="image/x-icon" href="{{ icon }}">
    <link href="{{ bootstrapcss }}" rel="stylesheet">
    <script src="{{bootstrapjs}}"></script>
    <link rel="stylesheet" href="{{bootstrapicons}}">
    <!-- <link rel="stylesheet" href="{{ maincss }}"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/template/css/style.css">
</head>
<style>
    body {
     background-image: url("{{ assets }}");
     background-color: #cccccc;
    }
    
    </style>
<body>
    

    <div class="container cat" id="container">
        <div class="form-container sign-up">
            <form method="post" action="{{ registerform }}" >
                <h2>Create Account</h2>
                <div class="social-icons">
                    <a href="{{ discordlink }}" class="icon"><i class="fa-brands fa-discord"></i></a>
                </div>
                <span>or use your email for registeration</span>
                <input type="password" name="password" id="password" placeholder="Password">
                <input type="password" name="re_password" id="re_password" placeholder="Reapt Password">
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="post" action="{{ loginform }}">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="{{ discordlink }}" class="icon"><i class="fa-brands fa-discord"></i></a>
                </div>
                <span>or use your email password</span>
                <input type="text" placeholder="Username" name="username">
                <input type="password" placeholder="Password" name="password">
                <a href="#">Forget Your Password?</a>
                <button>Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Accessing the PHP variable value in JavaScript
    var generatorUsernameSetting = "{{ genusername }}";

    // Check if generatorUsernameSetting is true before generating usernames
    window.onload = function() {
        if (generatorUsernameSetting === 'true') { // Check the string value 'true'
            const passwordInput = document.getElementById('password');
            const rePasswordInput = document.getElementById('re_password');

            if (passwordInput && rePasswordInput) {
                const generatedUsername = generateRandomString(8);

                passwordInput.value = generatedUsername; // Using the same name as the password
                rePasswordInput.value = generatedUsername;
            }
        }
    };

    function generateRandomString(length) {
        const characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let randomString = '';
        for (let i = 0; i < length; i++) {
            randomString += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        return randomString;
    }
</script>

    
    <script src="/template/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>