<?
/**
 * @var  SiteController  $this
 * @var  Poem            $poem
 */
?>
<div class="container poem-page">
	<div class="row">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-3">
					<img class="thumbnail author-image" src="<?= $poem->author->avatar->url ?>"/>
				</div>
				<div class="col-sm-9">
					<h3><?= $this->text($poem->title) ?></h3>
					<div>by <a href=""><?= $this->text($poem->author->name) ?></a></div>
				</div>
			</div>
			<div class="poem-text"><?= $this->text($poem->text) ?></div>
			<br/>
			<div>
				<button type="button" class="btn btn-primary btn-lg record-now">Record your version now!</button>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="well now-playing">
				<h4>Now playing</h4>
				<div  class="row">
					<div class="col-sm-3">
						<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_3.jpg" />
					</div>
					<div class="col-sm-9 recited-by">
						<div>recited by</div>
						<h4><a href="#">robratterman</a></h4>
					</div>
				</div>
				<div><img src="<?= Yii::app()->baseUrl ?>/assets/img/player_stub.png" width="100%" height="30px" /></div>
			</div>

			<h4 class="recitations-header">poemz recitations</h4>
			<div class="recitations">
				<div class="row">
					<div class="col-sm-2 text-center">
						<h5 class="index">1</h5>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default listen">Listen</button>
					</div>
					<div class="col-sm-8">
						<img class="thumbnail pull-left" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_3.jpg" />
						<div class="info pull-left">
							<div class="username"><a href="#">robratterman</a></div>
							<div class="row">
								<div class="col-sm-6">
									<nobr><img src="<?= Yii::app()->baseUrl ?>/assets/img/thumb_up.png"/> 42 votes</nobr>
								</div>
								<div class="col-sm-6">
									<nobr>
										<img src="<?= Yii::app()->baseUrl ?>/assets/img/comments_sm.png"/>
										<a href="#">30 comments</a>
									</nobr>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 text-center">
						<h5 class="index">2</h5>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default listen">Listen</button>
					</div>
					<div class="col-sm-8">
						<img class="thumbnail pull-left" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_4.jpg" />
						<div class="info pull-left">
							<div class="username"><a href="#">robert-bobert</a></div>
							<div class="row">
								<div class="col-sm-6">
									<nobr><img src="<?= Yii::app()->baseUrl ?>/assets/img/thumb_up.png"/> 42 votes</nobr>
								</div>
								<div class="col-sm-6">
									<nobr>
										<img src="<?= Yii::app()->baseUrl ?>/assets/img/comments_sm.png"/>
										<a href="#">30 comments</a>
									</nobr>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 text-center">
						<h5 class="index">3</h5>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default listen">Listen</button>
					</div>
					<div class="col-sm-8">
						<img class="thumbnail pull-left" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_5.jpg" />
						<div class="info pull-left">
							<div class="username"><a href="#">sergey</a></div>
							<div class="row">
								<div class="col-sm-6">
									<nobr><img src="<?= Yii::app()->baseUrl ?>/assets/img/thumb_up.png"/> 42 votes</nobr>
								</div>
								<div class="col-sm-6">
									<nobr>
										<img src="<?= Yii::app()->baseUrl ?>/assets/img/comments_sm.png"/>
										<a href="#">30 comments</a>
									</nobr>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
