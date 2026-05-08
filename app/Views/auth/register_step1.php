<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="col-md-8 col-lg-6">
	<div class="wrapper">
		<div class="contact-wrap w-100 p-md-5 p-4">
<h3 class="mb-4">Créer votre compte</h3>
		<p class="text-muted mb-4"><small>Étape 1 sur 2 : Informations personnelles</small></p>
			
			<?php if (session()->has('error')): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= session('error') ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>
			
			<form method="POST" action="<?= base_url('register/step1') ?>">
				<?= csrf_field() ?>
				
				<div class="form-row">
					<div class="form-group col-md-6">
					<label class="label" for="nom">Nom</label>
					<input type="text" class="form-control <?= session('errors.nom') ? 'is-invalid' : '' ?>" name="nom" id="nom" placeholder="Nom" required value="<?= old('nom') ?>">
						<?php if (session('errors.nom')): ?>
							<div class="invalid-feedback d-block"><?= session('errors.nom') ?></div>
						<?php endif; ?>
					</div>
					<div class="form-group col-md-6">
					<label class="label" for="prenom">Prénom</label>
					<input type="text" class="form-control <?= session('errors.prenom') ? 'is-invalid' : '' ?>" name="prenom" id="prenom" placeholder="Prénom" required value="<?= old('prenom') ?>">
						<?php if (session('errors.prenom')): ?>
							<div class="invalid-feedback d-block"><?= session('errors.prenom') ?></div>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="form-group">
				<label class="label" for="email">Adresse email</label>
				<input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" id="email" placeholder="Entrez votre email" required value="<?= old('email') ?>">
					<?php if (session('errors.email')): ?>
						<div class="invalid-feedback d-block"><?= session('errors.email') ?></div>
					<?php endif; ?>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-6">
					<label class="label" for="password">Mot de passe</label>
					<input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" id="password" placeholder="Entrez le mot de passe" required>
						<?php if (session('errors.password')): ?>
							<div class="invalid-feedback d-block"><?= session('errors.password') ?></div>
						<?php endif; ?>
					</div>
					<div class="form-group col-md-6">
					<label class="label" for="password_confirm">Confirmer le mot de passe</label>
					<input type="password" class="form-control <?= session('errors.password_confirm') ? 'is-invalid' : '' ?>" name="password_confirm" id="password_confirm" placeholder="Confirmer le mot de passe" required>
						<?php if (session('errors.password_confirm')): ?>
							<div class="invalid-feedback d-block"><?= session('errors.password_confirm') ?></div>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-6">
					<label class="label" for="genre">Genre</label>
					<select class="form-control <?= session('errors.genre') ? 'is-invalid' : '' ?>" name="genre" id="genre" required>
						<option value="">Sélectionnez le genre</option>
						<option value="M" <?= old('genre') === 'M' ? 'selected' : '' ?>>Homme</option>
						<option value="F" <?= old('genre') === 'F' ? 'selected' : '' ?>>Femme</option>
						<option value="Autre" <?= old('genre') === 'Autre' ? 'selected' : '' ?>>Autre</option>
						</select>
						<?php if (session('errors.genre')): ?>
							<div class="invalid-feedback d-block"><?= session('errors.genre') ?></div>
						<?php endif; ?>
					</div>
					<div class="form-group col-md-6">
					<label class="label" for="date_naissance">Date de naissance</label>
						<input type="date" class="form-control <?= session('errors.date_naissance') ? 'is-invalid' : '' ?>" name="date_naissance" id="date_naissance" required value="<?= old('date_naissance') ?>">
						<?php if (session('errors.date_naissance')): ?>
							<div class="invalid-feedback d-block"><?= session('errors.date_naissance') ?></div>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Étape suivante</button>
				</div>
			</form>
			
			<p class="text-center mt-3">
				Vous avez déjà un compte ? <a href="<?= base_url('login') ?>" class="text-primary">Connectez-vous ici</a>
			</p>
		</div>
	</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	const emailInput = document.getElementById('email');
	if (!emailInput) {
		return;
	}

	const feedbackId = 'email-availability-feedback';
	let timeoutId = null;

	emailInput.addEventListener('input', function () {
		clearTimeout(timeoutId);

		const email = this.value.trim();
		const existingFeedback = document.getElementById(feedbackId);

		if (existingFeedback) {
			existingFeedback.remove();
		}

		if (email.length < 4) {
			this.classList.remove('is-invalid', 'is-valid');
			return;
		}

		timeoutId = setTimeout(async () => {
			try {
				const response = await fetch('<?= base_url('register/check-email') ?>?email=' + encodeURIComponent(email), {
					headers: {
						'X-Requested-With': 'XMLHttpRequest'
					}
				});

				const data = await response.json();
				let feedback = document.getElementById(feedbackId);

				if (!feedback) {
					feedback = document.createElement('small');
					feedback.id = feedbackId;
					feedback.className = 'form-text';
					emailInput.insertAdjacentElement('afterend', feedback);
				}

				feedback.textContent = data.message;
				feedback.className = 'form-text ' + (data.available ? 'text-success' : 'text-danger');
				emailInput.classList.toggle('is-valid', data.available);
				emailInput.classList.toggle('is-invalid', !data.available);
			} catch (error) {
				console.error(error);
			}
		}, 400);
	});
});
</script>
<?= $this->endSection() ?>
