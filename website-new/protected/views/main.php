<!doctype html>
<html>
<head>
</head>
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=565093053580288";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<div class="modal fade" id="modal-sign-in" data-controller="login-form">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title sign-in-only">Sign In</h4>
					<h4 class="modal-title create-account-only">Create Account</h4>
				</div>
				<div class="modal-body">
					<h4 class="sign-in-only">Please enter your email and password or use your Facebook account</h4>
					<h4 class="create-account-only">Please fill out the form below or simply use your Facebook account</h4>
					<div class="row">
						<div class="col-sm-6">
							<form>
								<div class="alert alert-danger hide-light login-error">
									Please try again...
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" class="have-account" /> I already have an account
									</label>
								</div>
								<div class="form-group create-account-only">
									<input type="text" name="username" class="form-control" placeholder="Your 'stage name'" data-required="value" />
									<div class="errors"></div>
								</div>
								<div class="form-group">
									<input type="text" name="email" class="form-control" placeholder="Email" data-required="email" />
									<div class="errors"></div>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Password" data-required="value" />
									<div class="errors"></div>
								</div>
								<div class="form-group create-account-only">
									<input type="password" name="confirmation" class="form-control" placeholder="Retype your password" data-required="value" />
									<div class="errors"></div>
								</div>
								<div class="sign-in-only">
									<button type="button" class="btn btn-primary login-button">Log in</button>
									&nbsp;&nbsp;&nbsp;
									<a href="#">I forgot my password...</a>
								</div>
								<div class="create-account-only">
									<button type="button" class="btn btn-primary create-account-button">Create account</button>
								</div>
							</form>
						</div>
						<div class="col-sm-6">
							<div class="text-center facebook-button" data-controller="facebook-button">
								<div onlogin="facebookLogin"
									 class="fb-login-button"
									 data-max-rows="1"
									 data-size="large"
									 data-show-faces="false"
									 data-auto-logout-link="false"
									 data-scope="email">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="navbar navbar-default" data-controller="navbar">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?= $this->createUrl('site/index') ?>">
					<img class="navbar-logo" src="<?= Yii::app()->baseUrl ?>/assets/img/poemz_logo.png" />
				</a>
			</div>
			<div class="collapse navbar-collapse">
				<? if ($this->session == null): ?>
					<form class="navbar-form navbar-right">
						<button type="button" class="btn btn-primary sign-in" data-toggle="modal" data-target="#modal-sign-in">Sign in</button>
						<a href="#" class="create-account" data-toggle="modal" data-target="#modal-sign-in">or create account</a>
					</form>
				<? else: ?>
					<p class="navbar-text navbar-right">
						Welcome, <a href="#"><b><?= $this->text($this->session->user->username) ?></b></a>
						<span class="small">(<a href="<?= $this->createUrl('site/logout') ?>">not you?</a>)</span>
					</p>
				<? endif; ?>
				<form class="navbar-form text-center">
					<div class="form-group">
						<input type="search" class="form-control search-field" placeholder="Find your favorite poem" />
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="<?= $this->contentClass ?>">
		<?php echo $content ?>
	</div>

	<script type="text/javascript" language="JavaScript">
		app = app || {};
		app.config = {
			baseUrl: '<?= Yii::app()->baseUrl ?>'
		};
		app.data = <?= json_encode($this->page_data) ?>;
	</script>
</body>
</html>
