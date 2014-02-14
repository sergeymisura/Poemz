<!doctype html>
<html>
<head>
</head>
<body>
	<div class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand">
					<img class="navbar-logo" src="<?= Yii::app()->baseUrl ?>/assets/img/poemz_logo.png" />
				</a>
			</div>
			<div class="collapse navbar-collapse">
				<form class="navbar-form navbar-right">
					<button type="button" class="btn btn-primary">Sign in</button>
				</form>
				<form class="navbar-form navbar-right">
					<div class="form-group">
						<input type="search" class="form-control" placeholder="Find your favorite poem" />
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php echo $content ?>
</body>
</html>
