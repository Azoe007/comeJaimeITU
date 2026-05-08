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
    </div>
</div>
</body>
</html>