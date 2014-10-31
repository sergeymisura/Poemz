<?php
/**
 * @var  User  $user
 */
?>
<div class="profile-edit container" data-controller="profile-edit">
    <div class="row">
        <div class="col-sm-7">
            <h3>Your Poemz profile</h3>
            <br/>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-1">
                    <img src="<?= $user->getAvatar() ?>" class="img-thumbnail full-width avatar" />
                </div>
                <div class="col-sm-8">
                    <br/>
                    <div><button class="btn btn-default">Upload new avatar</button></div>
                    <br/>
                    <div>or use
                        <a href="#" class="external-avatar" data-source="Gravatar" title="Gravatar"><img class="img-thumbnail img-th-xs" src="<?= $user->getGravatar() ?>"/></a>
                        <?php if ($user->facebook): ?>
                            <a href="#" class="external-avatar" data-source="Facebook" title="Facebook"><img class="img-thumbnail img-th-xs" src="<?= $user->getFbAvatar() ?>"/></a>
                        <?php endif; ?>
                    </div>
					<div class="hide-light avatar-message">
						<br/>
						<div class="alert alert-success">Your avatar has been updated.</div>
					</div>
                </div>
            </div>
            <br/>
            <form class="form-horizontal profile-form">
				<div class="alert alert-success hide-light">Your profile has been updated.</div>
				<div class="alert alert-danger hide-light"></div>
                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                               id="email" name="email" data-required="email"
                               value="<?= $this->text($user->email) ?>"
                            />
                        <div class="errors"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-4 control-label">Stage name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                               id="username" name="username" data-required="value"
                               value="<?= $this->text($user->username) ?>"
                            />
                        <div class="errors"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="website" class="col-sm-4 control-label">Your website:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                                id="website" name="website"
                                value="<?= $this->text($user->website) ?>"
                            />
                        <div class="errors"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="about" class="col-sm-4 control-label">Few words about you:</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" style="height: 200px" id="about" name="about"><?= $this->text($user->about) ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-7 col-sm-offset-5">
                        <button class="btn btn-primary" type="submit">Save profile</button>
                        <button class="btn btn-default" type="reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-4 col-sm-offset-1">
            <h3>Social network accounts</h3>
            <br/>
            <div class="social-network">
                <div class="social-network-logo pull-left">
                    <img src="<?= Yii::app()->baseUrl ?>/assets/img/Facebook_72.png"/>
                </div>
                <div class="social-network-info">
                    <?php if ($user->facebook): ?>
                        <p>
                            You have linked your
                            <?php if ($user->facebook->link): ?>
                                <a href="<?= $this->text($user->facebook->link) ?>" target="_blank">Facebook account</a>
							<?php else: ?>
								Facebook account
                            <?php endif; ?>
							<br/>
                        </p>
                        <p>
                            <a class="btn-icon btn-toggle-profile" href="#"
							   title="<?= $user->facebook->is_public
								   ? 'A link to this profile is visible to others'
								   : 'Make it visible to others' ?>"
							   data-provider="<?= Identity::FACEBOOK ?>">
                                <i class="fa <?= $user->facebook->is_public ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i>
                            </a>
                            <a class="btn-icon" href="#" title="Unlink your Facebook account"><i class="fa fa-trash"></i></a>
                        </p>
                    <?php endif?>
                </div>
            </div>
            <hr/>
            <div class="social-network">
                <div class="social-network-logo pull-left">
                    <img src="<?= Yii::app()->baseUrl ?>/assets/img/GooglePlus_72.png"/>
                </div>
                <div class="social-network-info">
                    <br/>
                    <button type="button" class="btn btn-default">Link your Google+ account</button>
                </div>
            </div>
            <hr/>
            <div class="social-network">
                <div class="social-network-logo pull-left">
                    <img src="<?= Yii::app()->baseUrl ?>/assets/img/Twitter_72.png"/>
                </div>
                <div class="social-network-info">
                    <br/>
                    <button type="button" class="btn btn-default">Link your Twitter account</button>
                </div>
            </div>
        </div>
    </div>
</div>
