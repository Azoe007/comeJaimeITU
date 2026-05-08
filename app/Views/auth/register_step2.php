<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="col-md-8 col-lg-6">
	<div class="wrapper">
		<div class="contact-wrap w-100 p-md-5 p-4">
<h3 class="mb-4">Complétez votre profil</h3>
		<p class="text-muted mb-4"><small>Étape 2 sur 2 : Informations de santé</small></p>
			
			<?php if (session()->has('error')): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= session('error') ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>
			
			<form method="POST" action="<?= base_url('register/step2') ?>">
				<?= csrf_field() ?>
				
				<div class="form-row">
					<div class="form-group col-md-6">
					<label class="label" for="taille">Taille (cm)</label>
					<input type="number" step="0.01" class="form-control <?= session('errors.taille') ? 'is-invalid' : '' ?>" name="taille" id="taille" placeholder="Taille en cm" required value="<?= old('taille') ?>">
						<?php if (session('errors.taille')): ?>
							<div class="invalid-feedback d-block"><?= session('errors.taille') ?></div>
						<?php endif; ?>
					</div>
					<div class="form-group col-md-6">
					<label class="label" for="poids">Poids actuel (kg)</label>
					<input type="number" step="0.01" class="form-control <?= session('errors.poids') ? 'is-invalid' : '' ?>" name="poids" id="poids" placeholder="Poids en kg" required value="<?= old('poids') ?>">
						<?php if (session('errors.poids')): ?>
							<div class="invalid-feedback d-block"><?= session('errors.poids') ?></div>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Complete Registration</button>
				</div>
				
				<div class="form-group">
					<a href="<?= base_url('register') ?>" class="btn btn-secondary btn-block">Back to Step 1</a>
				</div>
			</form>
			
			<p class="text-center mt-3">
				Vous avez déjà un compte ? <a href="<?= base_url('login') ?>" class="text-primary">Connectez-vous ici</a>
			</p>
		</div>
	</div>
</div>

<?= $this->endSection() ?>
