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

		</div>

		<div class="col-sm-6">
			<ul class="nav nav-tabs nav-right nav-small">
				<li class="active"><a href="#" data-sort="new">Newest</a></li>
				<li><a href="#" data-sort="best">The best</a></li>
			</ul>

		</div>

	</div>
</div>
