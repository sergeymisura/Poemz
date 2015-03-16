<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<script type="text/javascript">
		var less = {
			env: 'development'
		};
	</script>
	<title><?= $this->text($this->pageTitle) ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-signin-clientid" content="189154397502-tjeouombgnrt818uuslba8io2gvg0su9.apps.googleusercontent.com" />
	<meta name="google-signin-scope" content="profile https://www.googleapis.com/auth/plus.profile.emails.read" />
	<meta name="google-signin-cookiepolicy" content="single_host_origin" />

	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script src="https://apis.google.com/js/client:platform.js" async defer></script>
</head>
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&version=v2.1&appId=<?= Yii::app()->params['fb_app_id'] ?>";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<div class="modal fade" id="modal-error" data-controller="error-message">
		<div class="modal-dialog">
			<div class="modal-content" data-template="error">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">${ title }</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-${ type }">${ text }</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-sign-in" data-controller="login-form">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title sign-in-only">Sign In</h4>
					<h4 class="modal-title create-account-only">Create Account</h4>
				</div>
				<div class="modal-body login-form">
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
							<div class="text-center" data-controller="social-login">
								<p>
									<span class="social-button facebook">Sign in with Facebook</span>
									<span class="social-button googleplus">Sign in with Google+</span>
									<span class="social-button twitter hide">Sign in with Twitter</span>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-body activation-form hide-light">
					<div data-template="activation">
						<h4>One last step to complete your registration...</h4>
						<div class="alert alert-info">
							We have sent you an email with the activation code. Please
							check your mailbox and copy the code into the form below.
						</div>
						<div class="alert alert-danger activation-error hide-light"></div>
						<br/>
						<div class="row">
							<div class="col-sm-9 col-sm-offset-1">
								<form class="form-horizontal">
									<input type="hidden" name="session_id" value="${ id }" />
									<div class="form-group">
										<label class="col-sm-5 control-label">Your 'stage' name:</label>
										<div class="col-sm-7">
											<input type="text" class="form-control"
												   placeholder="Your 'stage name'"
												   value="${ user.username }"
												   name="username"
												   data-required="value"
												/>
											<div class="errors"></div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-5 control-label">Activation code:</label>
										<div class="col-sm-7">
											<input type="text" class="form-control"
												   placeholder="Activation code"
												   name="activation_code"
												   data-required="value"
												/>
											<div class="errors"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-7 col-sm-offset-5">
											<div class="checkbox">
												<label>
													<input type="checkbox"
														   data-required="checked"
														   data-message="You must read and agree to the terms of use"
														   value="1" />
													I agree to the <a href="<?= Yii::app()->createUrl('site/terms') ?>" target="terms">terms of use</a>
												</label>
											</div>
											<div class="errors"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-7 col-sm-offset-5">
											<button type="button" class="btn btn-primary btn-activate">Continue</button>
										</div>
									</div>
								</form>
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
			<div class="collapse navbar-collapse" data-template="login-area">
				{{if user }}
					<p class="navbar-text navbar-right">
						Welcome, <a href="${ app.urls.user(user) }"><b>${ user.username }</b></a>
						<span class="small">(<a href="<?= $this->createUrl('site/logout') ?>">not you?</a>)</span>
					</p>
				{{else}}
					<form class="navbar-form navbar-right">
						<button type="button" class="btn btn-primary sign-in">Sign in</button>
						<a href="#" class="create-account">or create account</a>
					</form>
				{{/if}}
				<form class="navbar-form text-center" action="<?= Yii::app()->createUrl('site/search') ?>" method="get">
					<div class="form-group">
						<input type="search" class="form-control search-field" name="q" placeholder="Find your favorite poem"
							   value="<?= isset($_GET['q']) ? $this->text($_GET['q']) : '' ?>"
							/>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="<?= $this->contentClass ?>">
		<?php echo $content ?>
	</div>

	<br/><br/>

	<script type="text/javascript" language="JavaScript">
		app.config.baseUrl = '<?= Yii::app()->baseUrl == '' ? '/' : Yii::app()->baseUrl ?>';
		app.config.catchExceptions = false;
		app.data = <?= CJSON::encode($this->page_data) ?>;
	</script>
</body>
</html>
