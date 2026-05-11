<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<div class="admin-login-container">
    <div class="admin-login-box">
        <div class="admin-login-header">
            <div class="admin-logo">
                <span class="admin-logo-icon">⚙️</span>
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
