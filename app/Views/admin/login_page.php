<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<div class="admin-login-container">
    <div class="admin-login-box">
        <div class="admin-login-header">
            <div class="admin-logo">
                <span class="admin-logo-icon"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m5.08 5.08l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m5.08-5.08l4.24-4.24M19.78 19.78l-4.24-4.24m-5.08-5.08l-4.24-4.24"/></svg></span>
            </div>
            <h1>Panneau Admin</h1>
            <p>Health Coach - Gestion Administrative</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('admin/login') ?>" class="admin-login-form">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="votre@email.com"
                    value="<?= old('email') ?>"
                    required
                    class="form-input"
                />
                <?php if (isset($errors['email'])): ?>
                    <span class="error-text"><?= esc($errors['email']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="••••••••"
                    required
                    class="form-input"
                />
                <?php if (isset($errors['password'])): ?>
                    <span class="error-text"><?= esc($errors['password']) ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-admin-login">
                Connexion Admin
            </button>
        </form>

        <div class="admin-login-footer">
            <a href="<?= base_url('/') ?>" class="back-link">← Retour à l'accueil</a>
        </div>
    </div>

    <div class="admin-login-illustration">
        <div class="illustration-content">
            <div class="stat-box stat-box-1">
                <span class="stat-number">2,847</span>
                <span class="stat-label">Utilisateurs</span>
            </div>
            <div class="stat-box stat-box-2">
                <span class="stat-number">12,450</span>
                <span class="stat-label">Transactions</span>
            </div>
            <div class="stat-box stat-box-3">
                <span class="stat-number">89%</span>
                <span class="stat-label">Taux Gold</span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
