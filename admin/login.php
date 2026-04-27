<?php 
session_start();

// Check if already logged in
if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header("Location: /admin/dashboard.php");
    exit();
}

// Rate limiting to prevent brute force attacks
$max_attempts = 5;
$lockout_time = 15; // minutes

if(!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// Check if account is locked
if($_SESSION['login_attempts'] >= $max_attempts) {
    $time_diff = time() - $_SESSION['last_attempt_time'];
    if($time_diff < ($lockout_time * 60)) {
        $remaining_time = ceil((($lockout_time * 60) - $time_diff) / 60);
        $error_message = "Too many failed attempts. Please try again after {$remaining_time} minutes.";
        $locked = true;
    } else {
        // Reset attempts after lockout period
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = time();
        $locked = false;
    }
} else {
    $locked = false;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$locked) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // You can change these credentials or fetch from database
    $valid_username = 'admin';
    $valid_password = 'admin123';
    
    // Simple CSRF protection
    if(!isset($_SESSION['login_token'])) {
        $_SESSION['login_token'] = bin2hex(random_bytes(32));
    }
    
    if($username === $valid_username && password_verify($password, password_hash($valid_password, PASSWORD_DEFAULT))) {
        // Successful login
        $_SESSION['admin'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_login_time'] = time();
        $_SESSION['admin_ip'] = $_SERVER['REMOTE_ADDR'];
        
        // Reset login attempts
        $_SESSION['login_attempts'] = 0;
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Failed login attempt
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        
        $remaining_attempts = $max_attempts - $_SESSION['login_attempts'];
        if($remaining_attempts > 0) {
            $error = "Invalid username or password. {$remaining_attempts} attempts remaining.";
        } else {
            $error = "Too many failed attempts. Please try again after {$lockout_time} minutes.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | DevNexus IT</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->

    <style>
        
      body {
    background: #f7f8ff;
    position: relative;
    overflow-x: hidden;
}
        
        /* Animated background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }
        
        .login-card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
.login-header {
    background: #fff;
    color: #000;
    padding: 19px 20px 0;
    text-align: center;
}
        .login-header img {
            width: 60px;
        }
        
        .login-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .login-header p {
            opacity: 0.9;
            margin: 0;
            font-size: 0.9rem;
        }
        
       .login-body {
    padding: 22px 30px;
}
        
        .input-group-custom {
            position: relative;
            margin-bottom: 25px;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 1.1rem;
            z-index: 1;
        }
        
        .input-group-custom input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
            background: #f8fafc;
        }
        
        .input-group-custom input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .password-toggle {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a0aec0;
            z-index: 1;
            background: transparent;
            border: none;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
      .btn-login {
    background: linear-gradient(135deg, #0c4a9a 0%, #1393f3 50%, #0968c8 100%);
    border: none;
    border-radius: 12px;
    padding: 12px;
    font-size: 1rem;
    font-weight: 600;
    color: white;
    width: 100%;
    transition: all 0.3s;
    cursor: pointer;
}
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 12px 15px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            animation: shake 0.5s ease;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
            20%, 40%, 60%, 80% { transform: translateX(2px); }
        }
        
        .alert-danger {
            background: #fed7d7;
            color: #c53030;
            border-left: 4px solid #c53030;
        }
        
        .alert-success {
            background: #c6f6d5;
            color: #22543d;
            border-left: 4px solid #22543d;
        }
        
        .alert-warning {
            background: #feebc8;
            color: #7b341e;
            border-left: 4px solid #7b341e;
        }
        
        .login-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            margin-top: 20px;
        }
        
        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        /* Security badge */
        .security-badge {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: #a0aec0;
        }
        
        .security-badge i {
            margin: 0 3px;
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: none;
            margin-left: 10px;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-body {
                padding: 30px 20px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
            
            .login-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="https://devnexusit.com/images/favdev.webp">
                <h2>Admin Portal</h2>
                <p>Welcome back! Please login to your account</p>
            </div>
            
            <div class="login-body">
                <?php if(isset($error_message) && $error_message): ?>
                    <div class="alert alert-danger alert-custom">
                        <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>
                
                <?php if(isset($error) && $error): ?>
                    <div class="alert alert-danger alert-custom">
                        <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <?php if(isset($success) && $success): ?>
                    <div class="alert alert-success alert-custom">
                        <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>
                
                <?php if($locked): ?>
                    <div class="alert alert-warning alert-custom">
                        <i class="fas fa-lock me-2"></i> <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" id="loginForm">
                    <div class="input-group-custom">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required autocomplete="off" autofocus>
                    </div>
                    
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    
                    <button type="submit" class="btn-login" id="loginBtn">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                        <span class="loading-spinner" id="loadingSpinner">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </form>
                
                <div class="login-footer">
                    <a href="/">
                        <i class="fas fa-home me-1"></i> Back to Website
                    </a>
                </div>
                
                <div class="security-badge">
                    <i class="fas fa-shield-alt"></i> Secure Login
                    <i class="fas fa-circle" style="font-size: 4px; vertical-align: middle;"></i>
                    <i class="fas fa-lock"></i> SSL Encrypted
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        if(togglePassword && password) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
        
        // Form submission with loading state
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        
        if(loginForm) {
            loginForm.addEventListener('submit', function() {
                loginBtn.disabled = true;
                loadingSpinner.style.display = 'inline-block';
                loginBtn.querySelector('i').style.display = 'none';
            });
        }
        
        // Remember me functionality
        const rememberMe = document.getElementById('rememberMe');
        
        if(rememberMe) {
            // Check if there's saved username
            const savedUsername = localStorage.getItem('admin_username');
            if(savedUsername) {
                document.querySelector('input[name="username"]').value = savedUsername;
                rememberMe.checked = true;
            }
            
            // Save username if remember me is checked
            loginForm.addEventListener('submit', function() {
                if(rememberMe.checked) {
                    const username = document.querySelector('input[name="username"]').value;
                    localStorage.setItem('admin_username', username);
                } else {
                    localStorage.removeItem('admin_username');
                }
            });
        }
        
        // Add some animation to inputs
        const inputs = document.querySelectorAll('.input-group-custom input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
        
        // Prevent multiple form submissions
        let submitted = false;
        loginForm.addEventListener('submit', function(e) {
            if(submitted) {
                e.preventDefault();
                return false;
            }
            submitted = true;
        });
    </script>
</body>
</html>