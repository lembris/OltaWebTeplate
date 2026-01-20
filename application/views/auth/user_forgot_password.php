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

    .icon-circle {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }

    .icon-circle i {
        font-size: 1.8rem;
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
            <div class="icon-circle">
                <i class="bi bi-key"></i>
            </div>
            <h2>Forgot Password</h2>
            <p>Enter your email to reset your password</p>
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
            
            <?php echo form_open('users/auth/forgot_password', ['method' => 'POST']); ?>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-icon">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" id="email" class="form-control" 
                           placeholder="Enter your email" required 
                           value="<?= set_value('email') ?>">
                </div>
                <?= form_error('email', '<small class="text-danger">', '</small>') ?>
            </div>
            
            <button type="submit" class="btn-auth">
                Send Reset Link <i class="bi bi-send ms-2"></i>
            </button>
            
            <?php echo form_close(); ?>
        </div>
        
        <div class="auth-footer">
            <p style="margin: 0; color: #64748b; font-size: 0.85rem;">
                Remember your password? <a href="<?= base_url('users/auth/login') ?>">Sign in</a>
            </p>
            <p style="margin: 10px 0 0; color: #64748b; font-size: 0.85rem;">
                <a href="<?= base_url() ?>"><i class="bi bi-arrow-left"></i> Back to Home</a>
            </p>
        </div>
    </div>
</div>
