<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet</title>
</head>
<body>

<!-- Dans ton Header, à droite -->
<div class="header-right">
    <?php if (session()->get('is_gold')): ?>
        <span class="badge" style="background-color: #ffd700; color: #000;">✨ Membre Gold</span>
    <?php else: ?>
        <form action="<?= base_url('wallet/acheterGold') ?>" method="POST" style="display:inline;">
            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Devenir Gold pour 25 000 Ar ?')">
                👑 Devenir Gold (25 000 Ar)
            </button>
        </form>
    <?php endif; ?>
    
    <!-- Affichage du solde juste à côté -->
    <span class="ms-3">Solde: <?= number_format($solde_header ?? 0, 0, ',', ' ') ?> Ar</span>
</div>

    <div class="card">
    <div class="card-body">
        <h5>Votre solde actuel : <strong><?= number_format($solde ?? 0 , 0, ',', ' ') ?> Ar</strong></h5>
        <hr>
        <form action="<?= base_url('wallet/recharger') ?>" method="post">
            <div class="form-group">
                <label>Entrez votre code de recharge :</label>
                <input type="text" name="code_recharge" 
                       value="<?= isset($_GET['code']) ? esc($_GET['code']) : '' ?>" 
                       class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-2">Valider le code</button>
        </form>
=======
<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<?php
    $transactions = $transactions ?? [
        ['label' => 'Recharge par code HLT-2026-90', 'amount' => '+10 000 Ar', 'status' => 'Valide'],
        ['label' => 'Achat regime prise de masse 30 jours', 'amount' => '-22 000 Ar', 'status' => 'Debite'],
    ];
?>

<section class="page-hero compact">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Porte-monnaie</span>
            <h1>Rechargez votre solde avec un code.</h1>
            <p>Le portefeuille alimente les achats de regimes, les remises Gold et les exports de programme.</p>
        </div>
        <div class="wallet-balance">
            <span>Solde disponible</span>
            <strong><?= number_format($solde ?? 0, 0, ',', ' ') ?> Ar</strong>
        </div>
>>>>>>> e36906429cee746dd6360b099d23bbcf23329423
    </div>
</section>

<section class="content-section">
    <div class="container split-panel">
        <div class="feature-card" data-reveal="up">
            <span class="card-tag">Recharge</span>
            <h2>Entrer un code</h2>

            <?php if (session()->has('success')): ?><div class="alert-box alert-success"><?= session('success') ?></div><?php endif; ?>
            <?php if (session()->has('error')): ?><div class="alert-box alert-danger"><?= session('error') ?></div><?php endif; ?>

            <form action="<?= base_url('wallet/recharger') ?>" method="post" class="smart-form">
                <?= csrf_field() ?>
                <label class="field">
                    <span>Code de recharge</span>
                    <input type="text" name="code_recharge" placeholder="Ex: HC-GOLD-2026" required>
                </label>
                <button type="submit" class="btn btn-primary">Valider le code</button>
            </form>
        </div>

        <div class="feature-card" data-reveal="up">
            <span class="card-tag accent-tag">Historique</span>
            <h2>Mouvements recents</h2>
            <div class="list-stack">
                <?php foreach ($transactions as $transaction): ?>
                    <article class="list-item">
                        <div>
                            <strong><?= esc($transaction['label']) ?></strong>
                            <span><?= esc($transaction['status']) ?></span>
                        </div>
                        <b><?= esc($transaction['amount']) ?></b>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
