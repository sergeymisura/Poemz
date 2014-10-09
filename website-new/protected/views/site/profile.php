<?php
/**
 * @var  SiteController  $this
 * @var  User            $user
 * @var  bool            $own
 */

$own = $this->session ? $user->id == $this->session->user_id : false;
?>
<div class="container">
	<div class="row">

		<!-- Left side -->
		<div class="col-sm-6">

			<div class="row">
				<div class="col-sm-3">
					<img class="thumbnail full-width" src="<?= $user->getAvatar() ?>"/>
				</div>
				<div class="col-sm-9">
					<h3><?= $this->text($user->username) ?></h3>
					<?php if ($user->website): ?>
						<div><a href="<?= $user->website ?>" target="_blank"><i class="fa fa-globe"></i> <?= $user->websiteText ?></a></div>
					<?php endif; ?>
					<br/>
					<div>
						<?php if ($own): ?>
							<a class="btn-icon btn-toggle-edit" href="#" title="Edit your profile">
								<i class="fa fa-pencil-square-o"></i>
							</a>
						<?php else: ?>
							<a class="btn-icon" href="#" title="Follow <?= $this->text($user->username) ?>">
								<i class="fa fa-eye"></i>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php if ($user->about): ?>
				<p class="about"><?= $this->text($user->about) ?></p>
			<?php else: ?>
				<?php if ($own): ?>
					<div class="alert alert-info">
						<a href="#">Click here</a> to add some information about yourself!
					</div>
				<?php endif; ?>
			<?php endif; ?>

		</div>

		<div class="col-sm-6">
			<ul class="nav nav-tabs nav-right nav-small">
				<li><a href="#" data-sort="new">Newest</a></li>
				<li class="active"><a href="#" data-sort="best">The best</a></li>
			</ul>
			<div class="recitations-template">
				<div class="recitation row">
					<div class="col-xs-9">
						<div class="pull-left">
							<img class="thumbnail" src="http://local-dev.com/poemz-new/images/1.jpg" width="48px"/>
						</div>
						<div class="pull-left">
							<div><a href="#" class="title">Sonnet 20</a> by <a href="#" class="author">William Shakespeare</a></div>
							<div class="first-line">Shall I compare thee to a summer day...</div>
						</div>
					</div>
					<div class="col-xs-3 text-right">
						<a href="#" class="btn-icon vote-link" data-id="${ id }" data-action="vote" title="Vote for this recitation">
							<i class="fa fa-thumbs-o-up"></i> <span>1</span>
						</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
