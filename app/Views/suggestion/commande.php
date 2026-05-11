<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<?php $goldReduction = $goldReduction ?? 0; ?>

<section class="page-hero compact tunnel-hero">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Validation commande</span>
            <h1>Verifier et confirmer votre programme.</h1>
            <p>Votre objectif est memorise. Il reste a verifier votre porte-monnaie et confirmer la commande.</p>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container split-panel">
        <div class="feature-card" data-reveal="up">
            <span class="card-tag">Programme choisi</span>
            <h2><?= esc($suggestion['title']) ?></h2>
            <?php if (session()->has('error')): ?><div class="alert-box alert-danger"><?= session('error') ?></div><?php endif; ?>
            <?php if (session()->has('success')): ?><div class="alert-box alert-success"><?= session('success') ?></div><?php endif; ?>
            <div class="list-stack">
                <article class="list-item"><strong>Regime</strong><span><?= esc($suggestion['regime']) ?></span></article>
                <article class="list-item"><strong>Activite</strong><span><?= esc($suggestion['sport']) ?></span></article>
                <article class="list-item"><strong>Duree</strong><span><?= esc((string) $suggestion['duree']) ?> jours</span></article>
                <article class="list-item"><strong>Prix a payer</strong><span><?= number_format((float) $priceToPay, 0, ',', ' ') ?> Ar</span></article>
            </div>
        </div>

        <div class="feature-card" data-reveal="up">
            <span class="card-tag accent-tag">Porte-monnaie</span>
            <h2><?= $canAfford ? 'Solde suffisant' : 'Solde insuffisant' ?></h2>
            <div class="list-stack">
                <article class="list-item"><strong>Solde actuel</strong><span><?= number_format((float) $walletBalance, 0, ',', ' ') ?> Ar</span></article>
                <article class="list-item"><strong>Compte Gold</strong><span><?= $isGold ? 'Oui' : 'Non' ?></span></article>
                <article class="list-item"><strong>Reduction</strong><span><?= $isGold ? esc((string) $goldReduction) . '%' : '0%' ?></span></article>
            </div>
            <div class="action-row">
                <a class="btn btn-soft" href="<?= base_url('wallet') ?>">Recharger mon porte-monnaie</a>
                <form method="post" action="<?= base_url('objectif/commande/payer') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary" <?= $canAfford ? '' : 'disabled' ?>>Confirmer la commande</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
