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
