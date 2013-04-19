<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="app">
<head>
	<title>CanDo Politics Donations Tools</title>
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="dropdown" href="">
					<a href="#" class="brand dropdown-toggle" data-toggle="dropdown">

						<?php if ($this->isAdmin): ?>
							CanDo Politics Admin 
						<?php elseif ($this->isManager): ?>
							<?= $this->managedAccount->display_name ?>
						<?php else: ?>
							CanDo Politics
						<?php endif ?>

						<?php if ($this->login): ?>
							<span class="caret"></span>
						<?php endif; ?>
					</a>
					<?php if ($this->login): ?>
					<ul class="dropdown-menu">
						<?php if ($this->login['is_admin']) : ?>
							<li><a href="<?= Yii::app()->createUrl('switch/admin') ?>"><strong>CanDo Politics Admin</strong></a></li>
							<li class="divider"></li>
						<?php endif; ?>
						<?php $status = null;
							foreach ($this->accountList as $access): ?>
							<?php if ($status && $status != $access['status']): ?>
								<li class="divider"></li>
							<?php endif; $status = $access['status']; ?>
							<li>
								<a href="<?= Yii::app()->createUrl('switch') ?>/<?= $access['id'] ?>"><?= $access['display_name'] ?></a>
							</li>
						<?php endforeach ?> 
					</ul>
					<?php endif; ?>
				</a>

				<?php if ($this->isAdmin): ?>
				<ul class="nav">
					<li><a href="<?= Yii::app()->createUrl('admin/accounts') ?>">Accounts</a></li>
					<li><a href="<?= Yii::app()->createUrl('admin/paypal') ?>">PayPal Credentials</a></li>
					<li><a href="<?= Yii::app()->createUrl('admin/php-info') ?>">PHP Info</a></li>
					<li><a href="<?= Yii::app()->createUrl('logout') ?>">Log out</a></li>
				</ul>
				<?php elseif ($this->isManager): ?>
				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?= Yii::app()->createUrl('manager/emails') ?>">Emails</a></li>
						</ul>
					</li>
					<?php if ($this->managedAccount->id == 23 || $this->managedAccount->id == 25): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Store <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?= Yii::app()->createUrl('manager/orders') ?>">New orders</a></li>
							<li><a href="<?= Yii::app()->createUrl('manager/orders/shipped') ?>">Shipped orders</a></li>
						</ul>
					</li>
					<?php endif; ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Donations <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?= Yii::app()->createUrl('/') ?>/../user/view.php">View</a></li>
							<li><a href="<?= Yii::app()->createUrl('/') ?>/../user/checks.php">Enter checks</a></li>
						</ul>
					</li>
					<li><a href="<?= Yii::app()->createUrl('/') ?>/../user">Old console</a></li>
					<li><a href="<?= Yii::app()->createUrl('logout') ?>">Log out</a></li>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="page-content">
		<?php echo $content; ?>
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