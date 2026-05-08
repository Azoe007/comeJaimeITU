<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="col-md-8 col-lg-6">
	<div class="wrapper">
		<div class="contact-wrap w-100 p-md-5 p-4">
			<h3 class="mb-4">Connectez-vous à votre compte</h3>
			<?php if (session()->has('error')): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= session('error') ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>
			
			<form method="POST" action="<?= base_url('login') ?>">
				<?= csrf_field() ?>
				<div class="form-group">
				<label class="label" for="email">Adresse email</label>
				<input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" name="email" id="email" placeholder="Entrez votre email" required value="<?= old('email') ?>">
					<?php if (session('errors.email')): ?>
						<div class="invalid-feedback d-block"><?= session('errors.email') ?></div>
					<?php endif; ?>
				</div>
				
				<div class="form-group">
				<label class="label" for="password">Mot de passe</label>
				<input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" name="password" id="password" placeholder="Entrez votre mot de passe" required>
					<?php if (session('errors.password')): ?>
						<div class="invalid-feedback d-block"><?= session('errors.password') ?></div>
					<?php endif; ?>
				</div>
				
				<div class="form-group">
				<input type="submit" value="Connexion" class="btn btn-primary btn-block">
				</div>
			</form>
			
			<p class="text-center mt-3">
				Vous n'avez pas de compte ? <a href="<?= base_url('register') ?>" class="text-primary">Inscrivez-vous ici</a>
			</p>
		</div>
	</div>
</div>

<?= $this->endSection() ?>
