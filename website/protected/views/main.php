<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app">
<head>
	<title>Poemz.org</title>
</head>
<body>
	<div class="navbar navbar-fixed-top" data-controller="navbar">
		<div class="navbar-inner">
			<div class="container">
				<a href="<?= $this->createUrl('/') ?>" class="brand span2">Poemz.org</a>
				<form class="navbar-search pull-left">
					<input type="text" class="search-query input-xlarge" placeholder="Search for a poem" />
					<div class="popover bottom popover-search">
						<div class="arrow"></div>
						<div class="popover-content">
							<h5>Authors</h5>
							<div data-template="search-author" class="search-result">
								<a href="">${ name }</a>
							</div>
							<hr/>
							<h5>Poems</h5>
							<div data-template="search-poem" class="search-result">
								<div>${weight} <a href="">${ title }</a> by <a href="">${ author_name }</a></div>
								<div class="first-line"><a href="">${ first_line }</a></div>
							</div>
						</div>
					</div>
				</form>
				<ul class="nav pull-right user-box hide" data-template="user-box">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, ${ username }! <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Your profile</a></li>
							{{if activation_code}}
							<li><a href="#">Verify email</a></li>
							{{/if}}
							<li><a href="#">Log out</a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav pull-right login-box hide">
					<li>
						<a href="#" class="login">Log in or create account</a>
						<div class="popover bottom popover-login">
							<div class="arrow"></div>
							<div class="popover-content">
								<div class="validation-group">
									<input type="text" class="auth-email" placeholder="Email address" data-required="email" />
									<div class="errors"></div>
								</div>
								<div class="validation-group">
									<input type="password" class="auth-password" placeholder="Password" data-required="value" />
									<div class="errors"></div>
								</div>
								<div class="create-account-controls hide">
									<div class="validation-group">
										<input type="password" class="auth-confirm" placeholder="Confirm password" data-required="value" />
										<div class="errors"></div>
									</div>
									<div class="validation-group">
										<input type="text" class="auth-username" placeholder="Choose nickname" data-required="value" />
										<div class="errors"></div>
									</div>
									<div><button class="btn btn-primary create-account-button">Create account</button></div>
									<hr/>
									<div><a href="javascript:void(0)" class="switch-to-login">Already have an account?</a></div>
								</div>
								<div class="log-in-controls">
									<label class="label label-important login-error hide">Sorry, this password is incorrect</label>
									<div><button class="btn btn-primary login-button">Log in</button> <button class="btn pull-right switch-to-create">or create account.</button></div>
									<hr/>
									<div><a href="">Forgot your password?</a></div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="page-content">
		<div class="container">
			<?php echo $content; ?>
		</div>
	</div>

	<script type="text/javascript">
		(function($) {
			app.config = {
				baseUrl: <?php echo json_encode(Yii::app()->createAbsoluteUrl('')) ?>
			};

			app.data = <?php echo json_encode($this->pageData); ?>;
		})(jQuery);
	</script>
</body>
</html>