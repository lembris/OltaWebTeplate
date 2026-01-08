<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login - <?= isset($site_name) ? $site_name : 'Safari Tours' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --primary-dark: #1a252f;
            --accent-color: #e67e22;
            --accent-hover: #d35400;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, #0f1419 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Background Pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23e67e22' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }
        
        /* Floating Elements */
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
            opacity: 0.1;
            animation: float 15s infinite ease-in-out;
        }
        
        .floating-element:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            animation-delay: 5s;
        }
        
        .floating-element:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 10%;
            animation-delay: 10s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }
        
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        
        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 40px;
            background: #fff;
            border-radius: 50% 50% 0 0;
        }
        
        .login-logo {
            margin-bottom: 15px;
        }
        
        .login-logo img {
            max-width: 120px;
            height: auto;
        }
        
        .login-logo h2 {
            color: #fff;
            font-weight: 700;
            margin: 0;
        }
        
        .login-logo h2 span {
            color: var(--accent-color);
        }
        
        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            margin: 10px 0 0;
            font-size: 0.9rem;
        }
        
        .login-body {
            padding: 30px 40px 40px;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-floating > .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            height: 55px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-floating > .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(230, 126, 34, 0.1);
        }
        
        .form-floating > label {
            padding: 1rem 1rem 1rem 3rem;
            color: #999;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 10;
            transition: color 0.3s ease;
        }
        
        .form-floating:focus-within .input-icon {
            color: var(--accent-color);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            z-index: 10;
            padding: 5px;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .form-check {
            margin-bottom: 25px;
        }
        
        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.25);
        }
        
        .form-check-label {
            color: #666;
            font-size: 0.9rem;
        }
        
        .forgot-link {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: var(--accent-hover);
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(230, 126, 34, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .btn-login .spinner-border {
            width: 1.2rem;
            height: 1.2rem;
            margin-right: 8px;
        }
        
        /* Alerts */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
        }
        
        .alert-success {
            background: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
        }
        
        /* Validation */
        .is-invalid {
            border-color: var(--danger-color) !important;
        }
        
        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.8rem;
            margin-top: 5px;
        }
        
        /* Back to site link */
        .back-to-site {
            text-align: center;
            margin-top: 25px;
        }
        
        .back-to-site a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .back-to-site a:hover {
            color: #fff;
        }
        
        .back-to-site a i {
            margin-right: 5px;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-body {
                padding: 25px;
            }
            
            .login-header {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Background Elements -->
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <?php if (isset($site_logo) && $site_logo): ?>
                        <img src="<?= base_url('assets/images/' . $site_logo) ?>" alt="Logo">
                    <?php else: ?>
                        <h2><span>Safari</span> Admin</h2>
                    <?php endif; ?>
                </div>
                <p>Sign in to access your dashboard</p>
            </div>
            
            <div class="login-body">
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?= form_open('admin/auth/login', ['id' => 'loginForm']) ?>
                    
                    <div class="form-floating position-relative">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" 
                               class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" 
                               id="username" 
                               name="username" 
                               placeholder="Username or Email"
                               value="<?= set_value('username') ?>"
                               required>
                        <label for="username">Username or Email</label>
                        <?php if (form_error('username')): ?>
                            <div class="invalid-feedback"><?= form_error('username') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-floating position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" 
                               class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" 
                               id="password" 
                               name="password" 
                               placeholder="Password"
                               required>
                        <label for="password">Password</label>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                        <?php if (form_error('password')): ?>
                            <div class="invalid-feedback"><?= form_error('password') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="<?= base_url('admin/auth/forgot_password') ?>" class="forgot-link">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="btn-login" id="loginBtn">
                        <span class="btn-text">Sign In</span>
                    </button>
                    
                <?= form_close() ?>
            </div>
        </div>
        
        <div class="back-to-site">
            <a href="<?= base_url() ?>">
                <i class="fas fa-arrow-left"></i> Back to Website
            </a>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
        
        // Form Submit Loading State
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        
        loginForm.addEventListener('submit', function() {
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Signing In...';
        });
        
        // Auto-focus username field
        document.getElementById('username').focus();
    </script>
</body>
</html>
