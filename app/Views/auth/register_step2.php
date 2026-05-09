<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="form-shell">
    <div class="form-heading">
        <span class="step-pill">Etape 2 sur 2</span>
        <h2>Completer vos donnees de sante</h2>
        <p>Les mesures de base permettent d'afficher l'IMC et de suggerer le bon parcours.</p>
    </div>

    <div class="steps-bar">
        <span class="is-done">Profil</span>
        <span class="is-active">Sante</span>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert-box alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('register/step2') ?>" class="smart-form" data-imc-form>
        <?= csrf_field() ?>

        <div class="field-grid">
            <label class="field">
                <span>Taille (cm)</span>
                <input type="number" step="0.01" name="taille" id="taille" value="<?= old('taille') ?>" required>
                <?php if (session('errors.taille')): ?><small class="field-error"><?= session('errors.taille') ?></small><?php endif; ?>
            </label>

            <label class="field">
                <span>Poids actuel (kg)</span>
                <input type="number" step="0.01" name="poids" id="poids" value="<?= old('poids') ?>" required>
                <?php if (session('errors.poids')): ?><small class="field-error"><?= session('errors.poids') ?></small><?php endif; ?>
            </label>
        </div>

        <div class="imc-preview">
            <span>IMC estime</span>
            <strong data-imc-value>--</strong>
            <p data-imc-label>Entrez votre taille et votre poids pour obtenir un apercu immediat.</p>
        </div>

        <div class="action-row">
            <a class="btn btn-secondary btn-soft" href="<?= base_url('register') ?>">Retour</a>
            <button type="submit" class="btn btn-primary">Finaliser l'inscription</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
