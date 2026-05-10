<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<section class="page-hero compact">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Mon objectif</span>
            <h1>Suivi de votre objectif actuel.</h1>
            <p>Retrouvez votre dernier objectif enregistre et l'etat de votre dernier programme commande.</p>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container split-panel">
        <div class="feature-card" data-reveal="up">
            <span class="card-tag">Objectif actuel</span>
            <h2><?= $currentObjectif ? esc($currentObjectif['objectif_nom']) : 'Aucun objectif enregistre' ?></h2>
            <?php if ($currentObjectif): ?>
                <div class="list-stack">
                    <article class="list-item"><strong>Poids initial</strong><span><?= esc((string) $currentObjectif['poids_kg']) ?> kg</span></article>
                    <article class="list-item"><strong>Taille</strong><span><?= esc((string) $currentObjectif['taille_cm']) ?> cm</span></article>
                    <?php if (!empty($currentObjectif['poids_objectif'])): ?><article class="list-item"><strong>Poids objectif</strong><span><?= esc((string) $currentObjectif['poids_objectif']) ?> kg</span></article><?php endif; ?>
                    <article class="list-item"><strong>Date</strong><span><?= esc((string) $currentObjectif['created_at']) ?></span></article>
                </div>
            <?php else: ?>
                <p>Vous n'avez pas encore choisi d'objectif.</p>
            <?php endif; ?>
            <div class="action-row">
                <a class="btn btn-primary" href="<?= base_url('objectif/diagnostic') ?>">Changer mon objectif</a>
            </div>
        </div>

        <div class="feature-card" data-reveal="up">
            <span class="card-tag accent-tag">Programme</span>
            <h2><?= $latestProgramme ? 'Dernier programme commande' : 'Aucun programme commande' ?></h2>
            <?php if ($latestProgramme): ?>
                <div class="list-stack">
                    <article class="list-item"><strong>Duree</strong><span><?= esc((string) $latestProgramme['duree_jours']) ?> jours</span></article>
                    <article class="list-item"><strong>Prix</strong><span><?= number_format((float) $latestProgramme['prix_total'], 0, ',', ' ') ?> Ar</span></article>
                    <article class="list-item"><strong>Debut</strong><span><?= esc((string) $latestProgramme['date_debut']) ?></span></article>
                    <article class="list-item"><strong>Fin</strong><span><?= esc((string) $latestProgramme['date_fin']) ?></span></article>
                    <?php if ($latestTransaction): ?><article class="list-item"><strong>Transaction</strong><span><?= esc((string) $latestTransaction['etat']) ?></span></article><?php endif; ?>
                </div>
            <?php else: ?>
                <p>Aucune commande enregistree pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
