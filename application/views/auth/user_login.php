<style>
    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
        padding: 20px;
    }

    .auth-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 420px;
        overflow: hidden;
    }

    .auth-header {
        background: var(--theme-primary, #175cdd);
        color: white;
        padding: 30px;
        text-align: center;
    }

    .auth-header .logo {
        margin-bottom: 15px;
    }

    .auth-header .logo img {
        height: 50px;
        width: auto;
    }

    .auth-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .auth-header p {
        margin: 10px 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    .auth-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--theme-accent, #175cdd);
        box-shadow: 0 0 0 3px rgba(23, 92, 221, 0.1);
    }

    .btn-auth {
        width: 100%;
        padding: 14px;
        background: var(--theme-accent, #175cdd);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-auth:hover {
        background: var(--theme-primary, #175cdd);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(23, 92, 221, 0.3);
    }

    .auth-footer {
        text-align: center;
        padding: 20px 30px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    .auth-footer a {
        color: var(--theme-accent, #175cdd);
        text-decoration: none;
        font-weight: 600;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .alert-error {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .alert-success {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .input-icon .form-control {
        padding-left: 45px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        margin-bottom: 20px;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: var(--theme-accent, #175cdd);
    }

    @media (max-width: 480px) {
        .auth-card {
            max-width: 100%;
        }
        
        .auth-body {
            padding: 20px;
        }
    }
</style>

<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <div class="logo">
                <?php if (!empty($site_logo)): ?>
                <img src="<?= base_url($site_logo) ?>" alt="<?= htmlspecialchars($site_name) ?>">
                <?php else: ?>
                <h1><?= htmlspecialchars($site_name) ?></h1>
                <?php endif; ?>
            </div>
            <h2>Welcome Back</h2>
            <p>Sign in to your account</p>
        </div>
        
        <div class="auth-body">
            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-error">
                <?= $this->session->flashdata('error') ?>
            </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success') ?>
            </div>
            <?php endif; ?>
            
            <?php echo form_open('users/auth/login', ['method' => 'POST']); ?>
            
            <div class="form-group">
                <label for="username">Username or Email</label>
                <div class="input-icon">
                    <i class="bi bi-person"></i>
                    <input type="text" name="username" id="username" class="form-control" 
                           placeholder="Enter your username" required 
                           value="<?= set_value('username') ?>">
                </div>
                <?= form_error('username', '<small class="text-danger">', '</small>') ?>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-icon">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="password" class="form-control" 
                           placeholder="Enter your password" required>
                </div>
                <?= form_error('password', '<small class="text-danger">', '</small>') ?>
            </div>
            
            <button type="submit" class="btn-auth">
                Sign In <i class="bi bi-arrow-right ms-2"></i>
            </button>
            
            <?php echo form_close(); ?>
        </div>
        
        <div class="auth-footer">
            <p style="margin: 0; color: #64748b; font-size: 0.85rem;">
                <a href="<?= base_url('users/auth/forgot_password') ?>">Forgot your password?</a>
            </p>
            <p style="margin: 10px 0 0; color: #64748b; font-size: 0.85rem;">
                <a href="<?= base_url() ?>"><i class="bi bi-arrow-left"></i> Back to Home</a>
            </p>
        </div>
    </div>
</div>
