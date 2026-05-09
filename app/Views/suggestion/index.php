<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<section class="page-hero compact tunnel-hero">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Tunnel bilan - Etape 3</span>
            <h1>Votre suggestion personnalisee.</h1>
            <p>Presentation statique pour le moment, avec structure prete pour brancher l'algorithme final.</p>
        </div>
        <div class="funnel-progress">
            <span class="is-done">1. Diagnostic</span>
            <span class="is-done">2. Intention</span>
            <span class="is-active">3. Revelation</span>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container split-panel">
        <div class="feature-card suggestion-card" data-reveal="up">
            <span class="card-tag accent-tag">Suggestion</span>
            <h2>Pour atteindre <?= esc($suggestion['objectifLabel']) ?>, nous vous suggerons le Regime <?= esc($suggestion['regime']) ?> combine a <?= esc($suggestion['sport']) ?> sur une duree de <?= esc((string) $suggestion['duree']) ?> jours.</h2>
            <p>Le moteur pourra ensuite remplacer ces valeurs par le resultat reel de votre algorithme de suggestion.</p>

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
        </div>

        <div class="feature-card" data-reveal="up">
            <span class="card-tag">Action finale</span>
            <h2>Sauvegarder et commander ce programme</h2>
            <p>La redirection vers l'authentification n'intervient qu'ici si l'utilisateur n'est pas encore connecte.</p>

            <div class="list-stack">
                <article class="list-item"><strong>Regime cible</strong><span><?= esc($suggestion['regime']) ?></span></article>
                <article class="list-item"><strong>Activite sportive</strong><span><?= esc($suggestion['sport']) ?></span></article>
                <article class="list-item"><strong>Duree</strong><span><?= esc((string) $suggestion['duree']) ?> jours</span></article>
            </div>

            <div class="action-row">
                <a class="btn btn-soft" href="<?= base_url('objectif/intention') ?>">Modifier mon objectif</a>
                <a class="btn btn-primary" href="<?= $isLoggedIn ? base_url('plans') : base_url('login') ?>">Sauvegarder et commander ce programme</a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
