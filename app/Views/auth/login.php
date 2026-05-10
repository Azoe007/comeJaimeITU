<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="form-shell">
    <div class="form-heading">
        <span class="step-pill">Connexion</span>
        <h2>Accedez a votre espace nutrition</h2>
        <p>Retrouvez votre profil, votre porte-monnaie et vos programmes actifs.</p>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert-box alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('login') ?>" class="smart-form">
        <?= csrf_field() ?>

        <label class="field">
            <span>Adresse email</span>
            <input type="email" id="login-email" name="email" value="<?= old('email') ?>" required>
            <?php if (session('errors.email')): ?><small class="field-error"><?= session('errors.email') ?></small><?php endif; ?>
        </label>

        <label class="field">
            <span>Mot de passe</span>
            <input type="password" name="password" required>
            <?php if (session('errors.password')): ?><small class="field-error"><?= session('errors.password') ?></small><?php endif; ?>
        </label>

        <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
    </form>

    <p class="form-footnote">Pas encore de compte ? <a href="<?= base_url('register') ?>">Commencer l'inscription</a></p>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js-ajax/auth.js') ?>"></script>
<?= $this->endSection() ?>
