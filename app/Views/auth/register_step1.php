<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="form-shell">
    <div class="form-heading">
        <span class="step-pill">Etape 1 sur 2</span>
        <h2>Creer votre compte</h2>
        <p>Informations personnelles pour preparer votre espace utilisateur.</p>
    </div>

    <div class="steps-bar">
        <span class="is-active">Profil</span>
        <span>Sante</span>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert-box alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('register/step1') ?>" class="smart-form">
        <?= csrf_field() ?>

        <div class="field-grid">
            <label class="field">
                <span>Nom</span>
                <input type="text" name="nom" value="<?= old('nom') ?>" required>
                <?php if (session('errors.nom')): ?><small class="field-error"><?= session('errors.nom') ?></small><?php endif; ?>
            </label>

            <label class="field">
                <span>Prenom</span>
                <input type="text" name="prenom" value="<?= old('prenom') ?>" required>
                <?php if (session('errors.prenom')): ?><small class="field-error"><?= session('errors.prenom') ?></small><?php endif; ?>
            </label>
        </div>

        <label class="field">
            <span>Adresse email</span>
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
            <?php if (session('errors.email')): ?><small class="field-error"><?= session('errors.email') ?></small><?php endif; ?>
        </label>

        <div class="field-grid">
            <label class="field">
                <span>Mot de passe</span>
                <input type="password" name="password" required>
                <?php if (session('errors.password')): ?><small class="field-error"><?= session('errors.password') ?></small><?php endif; ?>
            </label>

            <label class="field">
                <span>Confirmation</span>
                <input type="password" name="password_confirm" required>
                <?php if (session('errors.password_confirm')): ?><small class="field-error"><?= session('errors.password_confirm') ?></small><?php endif; ?>
            </label>
        </div>

        <div class="field-grid">
            <label class="field">
                <span>Genre</span>
                <select name="genre" required>
                    <option value="">Selectionnez</option>
                    <option value="M" <?= old('genre') === 'M' ? 'selected' : '' ?>>Homme</option>
                    <option value="F" <?= old('genre') === 'F' ? 'selected' : '' ?>>Femme</option>
                    <option value="Autre" <?= old('genre') === 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select>
                <?php if (session('errors.genre')): ?><small class="field-error"><?= session('errors.genre') ?></small><?php endif; ?>
            </label>

            <label class="field">
                <span>Date de naissance</span>
                <input type="date" name="date_naissance" value="<?= old('date_naissance') ?>" required>
                <?php if (session('errors.date_naissance')): ?><small class="field-error"><?= session('errors.date_naissance') ?></small><?php endif; ?>
            </label>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Passer a l'etape sante</button>
    </form>

    <p class="form-footnote">Vous avez deja un compte ? <a href="<?= base_url('login') ?>">Se connecter</a></p>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js-ajax/auth.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');
    if (!emailInput) return;

    const feedbackId = 'email-availability-feedback';
    let timeoutId = null;

    emailInput.addEventListener('input', function () {
        clearTimeout(timeoutId);
        const email = this.value.trim();
        const existingFeedback = document.getElementById(feedbackId);
        if (existingFeedback) existingFeedback.remove();
        if (email.length < 4) return;

        timeoutId = setTimeout(async () => {
            try {
                const response = await fetch('<?= base_url('register/check-email') ?>?email=' + encodeURIComponent(email), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                let feedback = document.getElementById(feedbackId);
                if (!feedback) {
                    feedback = document.createElement('small');
                    feedback.id = feedbackId;
                    feedback.className = 'field-hint';
                    emailInput.insertAdjacentElement('afterend', feedback);
                }
                feedback.textContent = data.message;
                feedback.className = 'field-hint ' + (data.available ? 'hint-success' : 'hint-danger');
            } catch (error) {
                console.error(error);
            }
        }, 350);
    });
});
</script>
<?= $this->endSection() ?>
