<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<section class="page-hero compact tunnel-hero">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Tunnel bilan - Etape 3</span>
            <h1>Choisissez votre programme suggere.</h1>
            <p>Plusieurs propositions peuvent convenir a votre objectif <?= esc($objectifLabel) ?>. Cliquez sur un programme pour voir son detail complet avant la commande.</p>
        </div>
        <div class="funnel-progress">
            <span class="is-done">1. Diagnostic</span>
            <span class="is-done">2. Intention</span>
            <span class="is-active">3. Revelation</span>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="plans-grid suggestion-grid">
            <?php foreach (($suggestions ?? []) as $suggestion): ?>
                <article class="plan-card suggestion-list-card" data-reveal="up">
                    <div class="tag-row">
                        <?php foreach (($suggestion['tags'] ?? []) as $tag): ?>
                            <span class="card-tag"><?= esc($tag) ?></span>
                        <?php endforeach; ?>
                    </div>

                    <h2><?= esc($suggestion['title']) ?></h2>
                    <p><?= esc($suggestion['description']) ?></p>

                    <div class="list-stack compact-list">
                        <article class="list-item"><strong>Objectif</strong><span><?= esc($suggestion['goalText']) ?></span></article>
                        <article class="list-item"><strong>Activite</strong><span><?= esc($suggestion['sport']) ?></span></article>
                        <article class="list-item"><strong>Duree</strong><span><?= esc((string) $suggestion['duree']) ?> jours</span></article>
                    </div>

                    <div class="price-box">
                        <strong><?= number_format((float) $suggestion['prix'], 0, ',', ' ') ?> Ar</strong>
                        <span><?= number_format((float) $suggestion['prixGold'], 0, ',', ' ') ?> Ar Gold</span>
                    </div>

                    <a class="btn btn-primary btn-block" href="<?= base_url('suggestion/' . $suggestion['key']) ?>">Voir le detail du programme</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
