<?php
/**
 * @var  User  $user
 */
?>
<div class="profile-edit container" data-controller="profile-edit">
    <div class="row">
        <div class="col-sm-6">
            <h3>Your Poemz profile</h3>
            <br/>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2">
                    <img src="<?= $user->getAvatar() ?>" class="img-thumbnail full-width" />
                </div>
                <div class="col-sm-7">
                    <br/>
                    <div><button class="btn btn-default">Upload new avatar</button></div>
                    <br/>
                    <div>or use
                        <a href="#" title="Gravatar"><img class="img-thumbnail img-th-xs" src="<?= $user->getGravatar() ?>"/></a>
                        <?php if ($user->facebook_user_id): ?>
                            <a href="#" title="Facebook"><img class="img-thumbnail img-th-xs" src="<?= $user->getFbAvatar() ?>"/></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <br/>
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Email:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Stage name:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Your website:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">Few words about you:</label>
                    <div class="col-sm-7">
                        <textarea class="form-control" style="height: 200px"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-7 col-sm-offset-5">
                        <button class="btn btn-primary">Save profile</button>
                        <button class="btn btn-default">Reset</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <h3>Social networks profiles</h3>
        </div>
    </div>
</div>