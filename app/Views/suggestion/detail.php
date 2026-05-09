<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<section class="page-hero compact tunnel-hero">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Detail programme</span>
            <h1><?= esc($suggestion['title']) ?></h1>
            <p>Programme prepare pour atteindre <?= esc($objectifLabel) ?> avec un parcours plus lisible avant validation finale.</p>
        </div>
        <div class="funnel-progress">
            <span class="is-done">1. Diagnostic</span>
            <span class="is-done">2. Intention</span>
            <span class="is-active">3. Programme</span>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container split-panel">
        <div class="feature-card suggestion-card" data-reveal="up">
            <span class="card-tag accent-tag"><?= $suggestion['withActivity'] ? 'Avec activite' : 'Sans activite' ?></span>
            <h2>Pour atteindre <?= esc($objectifLabel) ?>, ce programme propose le regime <?= esc($suggestion['regime']) ?> sur <?= esc((string) $suggestion['duree']) ?> jours.</h2>
            <p><?= esc($suggestion['description']) ?></p>

            <div class="list-stack">
                <article class="list-item"><strong>Activite sportive</strong><span><?= esc($suggestion['sport']) ?></span></article>
                <article class="list-item"><strong>Organisation</strong><span><?= esc($suggestion['activityMeta']) ?></span></article>
                <article class="list-item"><strong>Variation cible</strong><span><?= ($suggestion['variation'] > 0 ? '+' : '') . esc((string) $suggestion['variation']) ?> kg</span></article>
            </div>

            <div class="macro-bar detail-macros">
                <div>Viande <?= esc((string) $suggestion['macros']['viande']) ?>%</div>
                <div>Poisson <?= esc((string) $suggestion['macros']['poisson']) ?>%</div>
                <div>Volaille <?= esc((string) $suggestion['macros']['volaille']) ?>%</div>
            </div>
        </div>

        <div class="feature-card" data-reveal="up">
            <span class="card-tag">Action finale</span>
            <h2>Sauvegarder et commander cet objectif</h2>
            <p>L'authentification n'intervient qu'ici si l'utilisateur n'est pas encore connecte.</p>

            <div class="price-offer">
                <div>
                    <span>Prix standard</span>
                    <strong><?= number_format((float) $suggestion['prix'], 0, ',', ' ') ?> Ar</strong>
                </div>
                <div>
                    <span>Prix Gold</span>
                    <strong class="gold-price"><?= number_format((float) $suggestion['prixGold'], 0, ',', ' ') ?> Ar</strong>
                    <small class="old-price"><?= number_format((float) $suggestion['prix'], 0, ',', ' ') ?> Ar</small>
                </div>
            </div>

            <div class="action-row">
                <a class="btn btn-soft" href="<?= base_url('suggestion') ?>">Retour aux suggestions</a>
                <a class="btn btn-primary" href="<?= $isLoggedIn ? base_url('plans') : base_url('login') ?>">Sauvegarder et commander cet objectif</a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
