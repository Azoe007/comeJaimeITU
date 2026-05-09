<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<?php
    $plans = $plans ?? [
        ['title' => 'Regime Equilibre 30 jours', 'goal' => 'IMC ideal', 'sport' => 'Cardio doux 3x/semaine', 'price' => '24 000 Ar', 'discount' => '20 400 Ar Gold'],
        ['title' => 'Programme Masse 45 jours', 'goal' => 'Prise de poids', 'sport' => 'Renforcement 4x/semaine', 'price' => '32 000 Ar', 'discount' => '27 200 Ar Gold'],
        ['title' => 'Deficit Controle 21 jours', 'goal' => 'Perte de poids', 'sport' => 'Marche active quotidienne', 'price' => '18 000 Ar', 'discount' => '15 300 Ar Gold'],
    ];
?>

<section class="page-hero compact">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Suggestions de regimes</span>
            <h1>Programmes proposes selon vos objectifs.</h1>
            <p>Chaque regime combine nutrition, duree, variation de poids attendue et activite sportive recommandee.</p>
        </div>
        <a class="btn btn-primary" href="#">Exporter en PDF</a>
    </div>
</section>

<section class="content-section">
    <div class="container plans-grid">
        <?php foreach ($plans as $plan): ?>
            <article class="plan-card" data-reveal="up">
                <span class="card-tag"><?= esc($plan['goal']) ?></span>
                <h2><?= esc($plan['title']) ?></h2>
                <p><?= esc($plan['sport']) ?></p>
                <div class="price-box">
                    <strong><?= esc($plan['price']) ?></strong>
                    <span><?= esc($plan['discount']) ?></span>
                </div>
                <div class="macro-bar">
                    <div style="width:40%">Viande 40%</div>
                    <div style="width:30%">Poisson 30%</div>
                    <div style="width:30%">Volaille 30%</div>
                </div>
                <a class="btn btn-secondary btn-soft" href="<?= base_url('wallet') ?>">Acheter avec mon porte-monnaie</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?= $this->endSection() ?>
