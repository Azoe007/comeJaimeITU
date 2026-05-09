<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<?php
    $user = $user ?? [
        'name' => trim((string) session('user_prenom') . ' ' . (string) session('user_nom')) ?: 'Jaime Rakoto',
        'goal' => 'Atteindre mon IMC ideal',
        'imc' => '23.1',
        'gender' => 'Homme',
        'height' => '178 cm',
        'weight' => '73 kg',
        'gold' => (bool) session('is_gold'),
    ];
?>

<section class="page-hero compact">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Mon profil</span>
            <h1><?= esc($user['name']) ?><?php if ($user['gold']): ?> <span class="gold-badge">GOLD</span><?php endif; ?></h1>
            <p>Complétez votre profil, choisissez un objectif et préparez votre prochaine recommandation alimentaire.</p>
        </div>
        <div class="bmi-card">
            <span>IMC actuel</span>
            <strong><?= esc($user['imc']) ?></strong>
            <p><?= esc($user['goal']) ?></p>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container card-grid">
        <article class="feature-card" data-reveal="up">
            <span class="card-tag">Informations</span>
            <h2>Profil utilisateur</h2>
            <div class="list-stack">
                <div class="list-item"><strong>Genre</strong><span><?= esc($user['gender']) ?></span></div>
                <div class="list-item"><strong>Taille</strong><span><?= esc($user['height']) ?></span></div>
                <div class="list-item"><strong>Poids</strong><span><?= esc($user['weight']) ?></span></div>
            </div>
        </article>

        <article class="feature-card" data-reveal="up">
            <span class="card-tag accent-tag">Objectifs</span>
            <h2>Choix disponibles</h2>
            <div class="goal-options">
                <button class="goal-chip is-active">Augmenter son poids</button>
                <button class="goal-chip">Reduire son poids</button>
                <button class="goal-chip">Atteindre son IMC ideal</button>
            </div>
        </article>

        <article class="feature-card" data-reveal="up">
            <span class="card-tag">Gold</span>
            <h2>Option premium</h2>
            <p>Paiement unique recommande: <strong>49 000 Ar</strong>. L'utilisateur Gold beneficie de 15% de remise sur tous les regimes.</p>
            <a class="btn btn-accent" href="<?= base_url('wallet') ?>">Devenir Gold</a>
        </article>
    </div>
</section>

<?= $this->endSection() ?>
