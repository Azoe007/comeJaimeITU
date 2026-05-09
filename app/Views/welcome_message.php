<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<?php
    $stats = $stats ?? [
        ['value' => '5+', 'label' => 'regimes adaptes'],
        ['value' => '5+', 'label' => 'activites sportives'],
        ['value' => '15%', 'label' => 'remise Gold'],
    ];
?>

<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-copy" data-reveal="up">
            <span class="eyebrow">Application de nutrition ciblee</span>
            <h1>Atteignez votre poids ideal avec un programme sur-mesure.</h1>
            <p>Renseignez votre profil, obtenez votre IMC, choisissez un objectif clair puis laissez l'application proposer le bon regime, l'activite sportive et la duree adaptee.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?= base_url('register') ?>">Calculer mon IMC</a>
                <a class="btn btn-secondary" href="<?= base_url('plans') ?>">Voir un exemple de programme</a>
            </div>
            <div class="hero-stats">
                <?php foreach ($stats as $item): ?>
                    <article class="stat-card">
                        <strong><?= esc($item['value']) ?></strong>
                        <span><?= esc($item['label']) ?></span>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="hero-visual" data-reveal="up">
            <div class="bmi-card floating">
                <span>Indice de masse corporelle</span>
                <strong>22.4</strong>
                <p>Zone ideale pour un objectif equilibre.</p>
            </div>
            <div class="goal-strip">
                <span>+ poids</span>
                <span>- poids</span>
                <span>IMC ideal</span>
            </div>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container card-grid">
        <article class="feature-card" data-reveal="up">
            <span class="card-tag">Parcours utilisateur</span>
            <h2>Inscription en 2 etapes</h2>
            <p>Une premiere page pour l'identite, une seconde pour les donnees de sante: taille, poids et projection IMC.</p>
        </article>
        <article class="feature-card" data-reveal="up">
            <span class="card-tag">Objectifs</span>
            <h2>3 trajectoires lisibles</h2>
            <p>Prendre du poids, reduire son poids ou viser directement un IMC ideal avec un accompagnement sportif associe.</p>
        </article>
        <article class="feature-card" data-reveal="up">
            <span class="card-tag accent-tag">Export PDF</span>
            <h2>Programme partageable</h2>
            <p>Chaque recommandation peut etre mise en forme pour impression ou export PDF afin de suivre le plan chaque semaine.</p>
        </article>
    </div>
</section>

<section class="gold-section">
    <div class="container gold-panel" data-reveal="up">
        <div>
            <span class="eyebrow accent">Option premium</span>
            <h2>Devenez Gold pour profiter de 15% de remise sur tous les regimes.</h2>
            <p>Acces en paiement unique propose a <strong>49 000 Ar</strong>, avec badge distinctif, avantages immediats et meilleure conversion sur chaque achat de programme.</p>
        </div>
        <a class="btn btn-accent" href="<?= base_url('profile') ?>">Decouvrir Gold</a>
    </div>
</section>

<section class="content-section">
    <div class="container split-panel">
        <div class="proof-copy" data-reveal="up">
            <span class="eyebrow">Preuve et couverture</span>
            <h2>Une base variée pour proposer des recommandations credibles.</h2>
            <p>L'application met en avant plus de 5 regimes et plus de 5 activites sportives pour couvrir plusieurs profils metabolique, budgets et rythmes de progression.</p>
        </div>
        <div class="proof-cards" data-reveal="up">
            <article class="mini-card">
                <strong>Regimes multi-durees</strong>
                <span>Tarifs ajustables selon la duree choisie.</span>
            </article>
            <article class="mini-card">
                <strong>Porte-monnaie integre</strong>
                <span>Rechargement par code et suivi des credits.</span>
            </article>
            <article class="mini-card">
                <strong>Back office complet</strong>
                <span>CRUD regimes, sports, codes et parametres.</span>
            </article>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
