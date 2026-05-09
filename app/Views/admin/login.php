<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion admin - Health Coach</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/back-office.css') ?>">
</head>
<body class="admin-auth-body">
    <div class="admin-auth-wrap">
        <section class="admin-auth-card" data-reveal="up">
            <span class="admin-kicker">Back Office</span>
            <h1>Connexion securisee</h1>
            <p>Point d'entree administratif pour le tableau de bord, les CRUD et la validation des codes.</p>
            <form class="admin-auth-form">
                <label>
                    <span>Email</span>
                    <input type="email" placeholder="admin@healthcoach.mg">
                </label>
                <label>
                    <span>Mot de passe</span>
                    <input type="password" placeholder="********">
                </label>
                <button type="button" class="admin-btn">Acceder au back office</button>
            </form>
        </section>

        <footer class="admin-footer standalone">
            <span>Health Coach Back Office</span>
            <span>Acces reserve a l'administration de la plateforme.</span>
        </footer>
    </div>
    <script src="<?= base_url('assets/js/back-office.js') ?>"></script>
</body>
</html>
