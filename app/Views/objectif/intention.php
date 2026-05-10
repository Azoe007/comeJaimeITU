<?= $this->extend('layouts/front') ?>
<?= $this->section('content') ?>

<section class="page-hero compact tunnel-hero">
    <div class="container page-hero-inner" data-reveal="up">
        <div>
            <span class="eyebrow">Tunnel bilan - Etape 2</span>
            <h1>Choisissez votre objectif prioritaire.</h1>
            <p>Selectionnez l'intention qui correspond a votre progression. Un champ de kilos apparait si l'objectif implique une variation de poids.</p>
        </div>
        <div class="funnel-progress">
            <span class="is-done">1. Diagnostic</span>
            <span class="is-active">2. Intention</span>
            <span>3. Revelation</span>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="feature-card" data-reveal="up">
            <span class="card-tag">Objectifs disponibles</span>
            <h2>Fixer mon objectif</h2>

            <?php if (session()->has('error')): ?><div class="alert-box alert-danger"><?= session('error') ?></div><?php endif; ?>
            <?php if (session('errors.objectif_id') || session('errors.target_kg')): ?><div class="alert-box alert-danger">Merci de selectionner un objectif valide.</div><?php endif; ?>

            <form method="post" action="<?= base_url('objectif/intention') ?>" class="smart-form" data-goal-form>
                <?= csrf_field() ?>

                <div class="objective-grid">
                    <?php foreach (($objectifs ?? []) as $objectif): ?>
                        <?php
                            $name = (string) ($objectif['nom'] ?? '');
                            $lower = strtolower($name);
                            $type = str_contains($lower, 'redu') ? 'reduire' : (str_contains($lower, 'augment') || str_contains($lower, 'gain') ? 'augmenter' : 'ideal');
                            $isSelected = (string) ($selectedObjectif ?? '') === (string) $objectif['id'];
                            $descriptions = [
                                'reduire' => 'Programme oriente perte de poids avec duree ciblee et activite associee.',
                                'augmenter' => 'Approche nutritionnelle pour prise de masse ou reprise progressive.',
                                'ideal' => 'Objectif poids sante pour converger vers un IMC ideal.',
                            ];
                        ?>
                        <label class="objective-card <?= $isSelected ? 'is-selected' : '' ?>" data-goal-card data-goal-type="<?= esc($type) ?>">
                            <input type="radio" name="objectif_id" value="<?= esc((string) $objectif['id']) ?>" <?= $isSelected ? 'checked' : '' ?> required>
                            <span class="objective-title"><?= esc($name) ?></span>
                            <span class="objective-text"><?= esc((string)$descriptions[$type]) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="target-field <?= ((string) ($selectedObjectif ?? '') !== '') ? '' : 'is-hidden' ?>" data-target-field>
                    <label class="field field-lg">
                        <span>Combien de kilos souhaitez-vous perdre/gagner ?</span>
                        <input type="number" step="0.1" min="0.1" name="target_kg" value="<?= esc((string) ($targetKg ?? '')) ?>" placeholder="Ex: 5">
                        <?php if (session('errors.target_kg')): ?><small class="field-error"><?= session('errors.target_kg') ?></small><?php endif; ?>
                    </label>
                </div>

                <div class="action-row">
                    <a class="btn btn-soft" href="<?= base_url('objectif/diagnostic') ?>">Retour au diagnostic</a>
                    <button type="submit" class="btn btn-primary">Voir ma suggestion personnalisee</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
