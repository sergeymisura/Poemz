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
			<h4 class="recitations-header">poemz recitations</h4>
			<div class="recitations">
				<div class="row">
					<div class="col-sm-2 text-center">
						<h5 class="index">1</h5>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default listen">Listen</button>
					</div>
					<div class="col-sm-6">
						<img class="thumbnail pull-left" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_3.jpg" />
						<div class="info pull-left">
							<div class="username"><a href="#">robratterman</a></div>
							<div><img src="<?= Yii::app()->baseUrl ?>/assets/img/rating_4.png"/> (42 votes)</div>
						</div>
					</div>
					<div class="col-sm-2">
						<a href="#" class="comments-count pull-right">32</a>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 text-center">
						<h5 class="index">2</h5>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default listen">Listen</button>
					</div>
					<div class="col-sm-6">
						<img class="thumbnail pull-left" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_4.jpg" />
						<div class="info pull-left">
							<div class="username"><a href="#">robert-bobert</a></div>
							<div><img src="<?= Yii::app()->baseUrl ?>/assets/img/rating_4.png"/> (42 votes)</div>
						</div>
					</div>
					<div class="col-sm-2">
						<a href="#" class="comments-count pull-right">15</a>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 text-center">
						<h5 class="index">3</h5>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default listen">Listen</button>
					</div>
					<div class="col-sm-6">
						<img class="thumbnail pull-left" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_5.jpg" />
						<div class="info pull-left">
							<div class="username"><a href="#">sergey</a></div>
							<div><img src="<?= Yii::app()->baseUrl ?>/assets/img/rating_4.png"/> (42 votes)</div>
						</div>
					</div>
					<div class="col-sm-2">
						<a href="#" class="comments-count pull-right">7</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
