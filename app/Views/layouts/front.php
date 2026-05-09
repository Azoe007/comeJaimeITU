<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($pageTitle ?? 'Health Coach') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/front-office.css') ?>">
</head>
<body class="app-shell">
    <?php
        $isLoggedIn = (bool) session('isLoggedIn');
        $isGold = (bool) session('is_gold');
        $userName = trim((string) session('user_prenom') . ' ' . (string) session('user_nom'));
    ?>
    <header class="site-header" data-reveal="down">
        <div class="container header-inner">
            <a class="brand" href="<?= base_url('/') ?>">
                <span class="brand-mark">HC</span>
                <span class="brand-copy">
                    <strong>Health Coach</strong>
                    <small>Nutrition et objectifs durables</small>
                </span>
            </a>

            <button class="nav-toggle" type="button" data-nav-toggle aria-label="Ouvrir le menu">
                <span></span>
                <span></span>
            </button>

            <nav class="site-nav" data-nav>
                <a href="<?= base_url('/') ?>">Accueil</a>
                <?php if ($isLoggedIn): ?>
                    <a href="<?= base_url('profile') ?>">Mon Profil</a>
                    <a href="<?= base_url('wallet') ?>">Mon Porte-monnaie</a>
                    <a href="<?= base_url('plans') ?>">Mes Regimes</a>
                    <a href="<?= base_url('logout') ?>">Deconnexion</a>
                <?php else: ?>
                    <a href="<?= base_url('register') ?>">Inscription</a>
                    <a href="<?= base_url('login') ?>">Connexion</a>
                <?php endif; ?>
            </nav>

            <?php if ($isLoggedIn): ?>
                <div class="header-user">
                    <span><?= esc($userName !== '' ? $userName : 'Utilisateur') ?></span>
                    <?php if ($isGold): ?><span class="gold-badge">GOLD</span><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <a class="brand footer-brand" href="<?= base_url('/') ?>">
                    <span class="brand-mark">HC</span>
                    <span class="brand-copy">
                        <strong>Health Coach</strong>
                        <small>Nutrition, IMC et objectifs durables</small>
                    </span>
                </a>
                <p>Une interface pensee pour guider l'utilisateur entre bilan, objectifs, recommandations et suivi du porte-monnaie.</p>
            </div>
            <div class="footer-links">
                <strong>Navigation</strong>
                <a href="<?= base_url('/') ?>">Accueil</a>
                <a href="<?= base_url('plans') ?>">Regimes</a>
                <a href="<?= base_url('wallet') ?>">Porte-monnaie</a>
            </div>
            <div class="footer-links">
                <strong>Avantages</strong>
                <span>IMC instantane</span>
                <span>Export PDF</span>
                <span>Option Gold -15%</span>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('assets/js/front-office.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
