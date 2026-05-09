<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet</title>
</head>
<body>
    <div class="card">
    <div class="card-body">
        <h5>Votre solde actuel : <strong><?= number_format($solde ?? 0 , 0, ',', ' ') ?> Ar</strong></h5>
        <hr>
        <form action="<?= base_url('wallet/recharger') ?>" method="post">
            <div class="form-group">
                <label>Entrez votre code de recharge :</label>
                <input type="text" name="code_recharge" class="form-control" placeholder="Ex: ABC-123" required>
            </div>
            <button type="submit" class="btn btn-success mt-2">Valider le code</button>
        </form>
    </div>
</div>
</body>
</html>