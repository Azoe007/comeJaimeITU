<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<section class="page-hero compact tunnel-hero">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Tunnel bilan - Etape 1</span>
            <h1>Diagnostiquer votre point de depart.</h1>
            <p>En 2 minutes, calculez votre IMC et decouvrez le programme ideal pour votre morphologie.</p>
        </div>
        <div class="funnel-progress">
            <span class="is-active">1. Diagnostic</span>
            <span>2. Intention</span>
            <span>3. Revelation</span>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container tunnel-grid">
        <div class="feature-card diagnostic-panel" data-reveal="up">
            <span class="card-tag">Interface moderne</span>
            <h2>Renseignez vos informations de base</h2>

            <?php if (session('errors')): ?>
                <div class="alert-box alert-danger">Merci de completer correctement les champs du diagnostic.</div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('objectif/diagnostic') ?>" class="smart-form diagnostic-form" data-diagnostic-form>
                <?= csrf_field() ?>

                <label class="field field-lg">
                    <span>Genre</span>
                    <select name="genre" required>
                        <option value="">Selectionnez votre genre</option>
                        <option value="M" <?= ($diagnostic['genre'] ?? '') === 'M' ? 'selected' : '' ?>>Homme</option>
                        <option value="F" <?= ($diagnostic['genre'] ?? '') === 'F' ? 'selected' : '' ?>>Femme</option>
                        <option value="Autre" <?= ($diagnostic['genre'] ?? '') === 'Autre' ? 'selected' : '' ?>>Autre</option>
                    </select>
                    <?php if (session('errors.genre')): ?><small class="field-error"><?= session('errors.genre') ?></small><?php endif; ?>
                </label>

                <div class="field-grid">
                    <label class="field field-lg">
                        <span>Taille (cm)</span>
                        <input type="number" step="0.01" id="taille" name="taille" value="<?= esc((string) ($diagnostic['taille'] ?? '')) ?>" placeholder="Ex: 172" required>
                        <?php if (session('errors.taille')): ?><small class="field-error"><?= session('errors.taille') ?></small><?php endif; ?>
                    </label>

                    <label class="field field-lg">
                        <span>Poids (kg)</span>
                        <input type="number" step="0.01" id="poids" name="poids" value="<?= esc((string) ($diagnostic['poids'] ?? '')) ?>" placeholder="Ex: 68" required>
                        <?php if (session('errors.poids')): ?><small class="field-error"><?= session('errors.poids') ?></small><?php endif; ?>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Etape suivante : Fixer mon objectif</button>
            </form>
        </div>

        <div class="feature-card gauge-panel" data-reveal="up">
            <span class="card-tag accent-tag">Resultat immediat</span>
            <h2>Votre IMC s'affiche en direct</h2>
            <div class="imc-preview imc-dashboard">
                <span>Indice de masse corporelle</span>
                <strong data-imc-value>--</strong>
                <p data-imc-label>Remplissez taille et poids pour voir votre diagnostic immediat.</p>
            </div>
            <div class="imc-gauge">
                <div class="imc-gauge-track">
                    <div class="imc-gauge-fill" data-imc-fill></div>
                </div>
                <div class="imc-gauge-legend">
                    <span>Bas</span>
                    <span>Normal</span>
                    <span>Surpoids</span>
                    <span>Eleve</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
