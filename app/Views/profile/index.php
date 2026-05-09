<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<?php
    $account = $account ?? [];
    $health = $health ?? [];
    $user = $user ?? [
        'name' => trim((string) session('user_prenom') . ' ' . (string) session('user_nom')) ?: 'Jaime Rakoto',
        'goal' => 'Atteindre mon IMC ideal',
        'imc' => '23.1',
        'gender' => 'Homme',
        'height' => '178 cm',
        'weight' => '73 kg',
        'gold' => (bool) session('is_gold'),
    ];
    $selectedGenre = (string) old('genre', $account['genre'] ?? '', 'raw');
?>

<section class="page-hero compact">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Mon profil</span>
            <h1><span data-profile-name><?= esc($user['name']) ?></span><?php if ($user['gold']): ?> <span class="gold-badge">GOLD</span><?php endif; ?></h1>
            <p>Complétez votre profil, choisissez un objectif et préparez votre prochaine recommandation alimentaire.</p>
        </div>
        <div class="bmi-card">
            <span>IMC actuel</span>
            <strong data-profile-imc><?= esc($user['imc']) ?></strong>
            <p><?= esc($user['goal']) ?></p>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container card-grid">
        <article class="feature-card profile-card" data-reveal="up">
            <span class="card-tag">Informations</span>
            <h2>Profil utilisateur</h2>

            <div class="profile-ajax-alerts" data-profile-alerts>
                <?php if (session()->has('success')): ?>
                    <div class="alert-box alert-success"><?= esc(session('success')) ?></div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div class="alert-box alert-danger"><?= esc(session('error')) ?></div>
                <?php endif; ?>
            </div>

            <form method="POST" action="<?= base_url('profile') ?>" class="smart-form profile-form" data-imc-form data-profile-form>
                <?= csrf_field('profile-csrf') ?>

                <div class="profile-form-section">
                    <h3>Informations du compte</h3>
                    <div class="field-grid">
                        <label class="field">
                            <span>Nom</span>
                            <input type="text" name="nom" value="<?= esc(old('nom', $account['nom'] ?? '', 'raw')) ?>" required>
                            <small class="field-error" data-error-for="nom"><?= esc(session('errors.nom') ?? '') ?></small>
                        </label>

                        <label class="field">
                            <span>Prenom</span>
                            <input type="text" name="prenom" value="<?= esc(old('prenom', $account['prenom'] ?? '', 'raw')) ?>" required>
                            <small class="field-error" data-error-for="prenom"><?= esc(session('errors.prenom') ?? '') ?></small>
                        </label>
                    </div>

                    <label class="field">
                        <span>Adresse email</span>
                        <input type="email" name="email" value="<?= esc(old('email', $account['email'] ?? '', 'raw')) ?>" required>
                        <small class="field-error" data-error-for="email"><?= esc(session('errors.email') ?? '') ?></small>
                    </label>

                    <div class="field-grid">
                        <label class="field">
                            <span>Genre</span>
                            <select name="genre" required>
                                <option value="">Selectionnez</option>
                                <option value="M" <?= $selectedGenre === 'M' ? 'selected' : '' ?>>Homme</option>
                                <option value="F" <?= $selectedGenre === 'F' ? 'selected' : '' ?>>Femme</option>
                                <option value="Autre" <?= $selectedGenre === 'Autre' ? 'selected' : '' ?>>Autre</option>
                            </select>
                            <small class="field-error" data-error-for="genre"><?= esc(session('errors.genre') ?? '') ?></small>
                        </label>

                        <label class="field">
                            <span>Date de naissance</span>
                            <input type="date" name="date_naissance" value="<?= esc(old('date_naissance', $account['date_naissance'] ?? '', 'raw')) ?>" required>
                            <small class="field-error" data-error-for="date_naissance"><?= esc(session('errors.date_naissance') ?? '') ?></small>
                        </label>
                    </div>

                    <div class="field-grid">
                        <label class="field">
                            <span>Nouveau mot de passe (optionnel)</span>
                            <input type="password" name="password" autocomplete="new-password">
                            <small class="field-error" data-error-for="password"><?= esc(session('errors.password') ?? '') ?></small>
                        </label>

                        <label class="field">
                            <span>Confirmation</span>
                            <input type="password" name="password_confirm" autocomplete="new-password">
                            <small class="field-error" data-error-for="password_confirm"><?= esc(session('errors.password_confirm') ?? '') ?></small>
                        </label>
                    </div>
                </div>

                <div class="profile-form-section">
                    <h3>Informations de sante</h3>
                    <div class="field-grid">
                        <label class="field">
                            <span>Taille (cm)</span>
                            <input type="number" step="0.01" name="taille" id="taille" value="<?= esc(old('taille', $health['taille'] ?? '', 'raw')) ?>" required>
                            <small class="field-error" data-error-for="taille"><?= esc(session('errors.taille') ?? '') ?></small>
                        </label>

                        <label class="field">
                            <span>Poids actuel (kg)</span>
                            <input type="number" step="0.01" name="poids" id="poids" value="<?= esc(old('poids', $health['poids'] ?? '', 'raw')) ?>" required>
                            <small class="field-error" data-error-for="poids"><?= esc(session('errors.poids') ?? '') ?></small>
                        </label>
                    </div>
                </div>

                <div class="imc-preview">
                    <span>IMC estime</span>
                    <strong data-imc-value><?= esc($user['imc']) ?></strong>
                    <p data-imc-label>La valeur se met a jour selon votre taille et votre poids.</p>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Enregistrer les modifications</button>
            </form>
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

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js-ajax/profile.js') ?>"></script>
<?= $this->endSection() ?>
