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
<body class="app-shell auth-shell">
    <header class="site-header" data-reveal="down">
        <div class="container header-inner">
            <a class="brand" href="<?= base_url('/') ?>">
                <span class="brand-mark">HC</span>
                <span class="brand-copy">
                    <strong>Health Coach</strong>
                    <small>Programme alimentaire intelligent</small>
                </span>
            </a>

            <button class="nav-toggle" type="button" data-nav-toggle aria-label="Ouvrir le menu">
                <span></span>
                <span></span>
            </button>

            <nav class="site-nav" data-nav>
                <a href="<?= base_url('/') ?>">Accueil</a>
                <a href="<?= base_url('register') ?>">Inscription</a>
                <a href="<?= base_url('login') ?>">Connexion</a>
            </nav>
        </div>
    </header>

    <main class="auth-main">
        <section class="auth-hero">
            <div class="container auth-grid">
                <div class="auth-copy" data-reveal="up">
                    <span class="eyebrow"><?= esc($breadcrumb ?? 'Authentification') ?></span>
                    <h1><?= esc($pageHeading ?? 'Bienvenue') ?></h1>
                    <p>Un parcours clair en plusieurs etapes pour estimer l'IMC, choisir un objectif, activer le porte-monnaie et acceder aux regimes proposes.</p>

                    <div class="auth-benefits">
                        <article class="mini-card">
                            <strong>IMC instantane</strong>
                            <span>Lecture simple de votre progression.</span>
                        </article>
                        <article class="mini-card">
                            <strong>Objectifs guides</strong>
                            <span>Prise de poids, perte ou IMC ideal.</span>
                        </article>
                        <article class="mini-card">
                            <strong>Remise Gold</strong>
                            <span>15% sur tous les regimes.</span>
                        </article>
                    </div>
                </div>

                <div class="auth-panel" data-reveal="up">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <a class="brand footer-brand" href="<?= base_url('/') ?>">
                    <span class="brand-mark">HC</span>
                    <span class="brand-copy">
                        <strong>Health Coach</strong>
                        <small>Acces simple aux programmes alimentaires</small>
                    </span>
                </a>
                <p>Parcours d'inscription en plusieurs etapes avec une presentation plus claire des objectifs et du suivi sante.</p>
            </div>
            <div class="footer-links">
                <strong>Acces rapide</strong>
                <a href="<?= base_url('/') ?>">Accueil</a>
                <a href="<?= base_url('register') ?>">Inscription</a>
                <a href="<?= base_url('login') ?>">Connexion</a>
            </div>
            <div class="footer-links">
                <strong>Fonctionnalites</strong>
                <span>IMC</span>
                <span>Objectifs personnalises</span>
                <span>Regimes avec remise Gold</span>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('assets/js/front-office.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
