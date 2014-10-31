<?php
/**
 * @var  SiteController  $this
 * @var  User            $user
 * @var  bool            $own
 */

$own = $this->session ? $user->id == $this->session->user_id : false;
?>
<div class="profile container" data-controller="profile">
	<div class="row">

		<!-- Left side -->
		<div class="col-sm-6">

			<div class="row">
				<div class="col-sm-3">
					<img class="thumbnail full-width" src="<?= $user->getAvatar() ?>"/>
				</div>
				<div class="col-sm-9">
					<h3>
						<div class="row">
							<div class="col-sm-8">
								<?= $this->text($user->username) ?>
							</div>
							<div class="col-sm-4">
								<?php foreach ($user->identities as $identity): if ($identity->link && $identity->is_public == '1'): ?>
									<a title="Meet <?= $this->text($user->username) ?> on <?= $identity->provider ?>" href="<?= $identity->link ?>" target="_blank"><img src="<?= Yii::app()->baseUrl ?>/assets/img/<?= $identity->provider ?>_29.png" /></a>
								<?php endif; endforeach; ?>
							</div>
						</div>
					</h3>
					<?php if ($user->website): ?>
						<p><a href="<?= $user->website ?>" target="_blank"><i class="fa fa-globe"></i> <?= $user->websiteText ?></a></p>
					<?php endif; ?>
					<div>
						<a class="btn-icon btn-edit own hide" href="<?= $this->createUrl('profile/edit', ['slug' => $user->slug]) ?>" title="Edit your profile">
							<i class="fa fa-pencil-square-o"></i>
						</a>
                        <?php if (!$own): ?>
                            <a class="btn-icon hide" href="#" title="Follow <?= $this->text($user->username) ?>">
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

		<div class="col-sm-6" data-controller="recitations" data-source="users/<?= $user->id ?>/recitations">
			<ul class="nav nav-tabs nav-right nav-small order">
				<li><a href="#" data-sort="new">Newest</a></li>
				<li class="active"><a href="#" data-sort="best">The best</a></li>
			</ul>
			<div class="recitation-template hide">
				<div class="recitation row" data-template="recitation">
					<div class="col-xs-9">
						<div class="pull-left">
							<img class="thumbnail" data-src="${ app.urls.image(poem.author.avatar_id) }"/>
						</div>
						<div class="info">
							<div>
								<a href="${ app.urls.recitation($data) }" class="title">${ poem.title }</a> by
								<a href="${ app.urls.author(poem.author) }" class="author">${ poem.author.name }</a>
							</div>
							<div class="first-line">${ poem.first_line }</div>
						</div>
					</div>
					<div class="col-xs-3 text-right actions">
						<a href="#" class="btn-icon vote-link" data-id="${ id }" data-action="vote" title="Vote for this recitation">
							<i class="fa fa-thumbs-o-up"></i> <span>${ votes }</span>
						</a>
					</div>
				</div>
			</div>

			<div class="alert alert-warning hide-light no-recordings">
				No one has recorded this poem yet! Be the first!
			</div>
			<div class="recitation-list"></div>

			<div class="loading"></div>

			<div class="more"><span class="pull-right more-tab">more</span></div>
		</div>
	</div>
</div>
