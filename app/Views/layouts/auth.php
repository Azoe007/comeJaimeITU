<!DOCTYPE html>
<html lang="fr">
  <head>
    <title><?= $pageTitle ?? 'Santé Coach' ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <link rel="stylesheet" href="<?= base_url('assets/css/animate.css') ?>">
    
    <link rel="stylesheet" href="<?= base_url('assets/css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/magnific-popup.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-datepicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery.timepicker.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/flaticon.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
  </head>
  <body>
		<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	    	<a class="navbar-brand" href="<?= base_url('/') ?>">Santé<span>coach<i class="fa fa-leaf"></i></span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="fa fa-bars"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
        	<li class="nav-item"><a href="<?= base_url('/') ?>" class="nav-link">Accueil</a></li>
        	<li class="nav-item"><a href="<?= base_url('/login') ?>" class="nav-link">Connexion</a></li>
        	<li class="nav-item"><a href="<?= base_url('/register') ?>" class="nav-link">Inscription</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

    <section class="hero-wrap hero-wrap-2" style="background-image: url('<?= base_url('assets/images/bg_2.jpg') ?>');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end">
          <div class="col-md-9 ftco-animate pb-5">
          <p class="breadcrumbs mb-2"><span class="mr-2"><a href="<?= base_url('/') ?>">Accueil <i class="ion-ios-arrow-forward"></i></a></span> <span><?= $breadcrumb ?? '' ?> <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-0 bread"><?= $pageHeading ?? '' ?></h1>
          </div>
        </div>
      </div>
    </section>
		
    <section class="ftco-section bg-light auth-section">
    	<div class="container">
    		<div class="row justify-content-center">
				<?= $this->renderSection('content') ?>
			</div>
    	</div>
    </section>

    <footer class="footer">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-10 col-lg-6">
					<div class="subscribe mb-5">
						<form action="#" class="subscribe-form">
              <div class="form-group d-flex">
                <input type="text" class="form-control rounded-left" placeholder="Entrez votre adresse email">
                <input type="submit" value="S'abonner" class="form-control submit px-3">
              </div>
            </form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-lg-5">
					<div class="row">
						<div class="col-md-12 col-lg-8 mb-md-0 mb-4">
							<h2 class="footer-heading"><a href="#" class="logo">Santé<span>coach</span></a></h2>
							<p>Un accompagnement simple pour mieux suivre votre santé au quotidien.</p>
							<a href="#">en savoir plus <span class="ion-ios-arrow-round-forward"></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
		<?= $this->renderSection('scripts') ?>
  </body>
</html>
