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
			<br/>
			<div>
				<img src="<?= Yii::app()->baseUrl ?>/assets/img/comments.png" class="pull-left" />
				<h5 class="pull-left comments-toggle"><a href="#">hide comments</a></h5>
			</div>
			<div class="clearfix"></div>
			<div class="comments">
				<div class="row comment">
					<div class="col-sm-2 text-center">
						<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_5.jpg" />
					</div>
					<div class="col-sm-10 comment-text">
						<p><a class="username" href="#">sergey</a> <span class="text-muted small pull-right">May 20, 2013 at 7:45am</span></p>
						<p class="small">I like Sheikspeer, but robratterman sucks!</p>
						<p class="small"><a href="#">Reply</a></p>
					</div>
				</div>
				<div class="row comment">
					<div class="col-sm-2 col-sm-offset-2">
						<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_3.jpg" />
					</div>
					<div class="col-sm-8 comment-text">
						<p><a class="username" href="#">robratterman</a> <span class="text-muted small pull-right">May 21, 2013 at 3:12am</span></p>
						<p class="small">It's 'Shakespeare', not 'Sheikspeer', you moron!</p>
					</div>
				</div>
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
				<div class="player"><img src="<?= Yii::app()->baseUrl ?>/assets/img/player_stub.png" width="100%" height="30px" /></div>
				<div class="row">
					<div class="col-sm-6">
						<h5><a href="#">Vote!</a></h5>
					</div>
					<div class="col-sm-6">
						<div class="pull-right">
							<img src="<?= Yii::app()->baseUrl ?>/assets/img/comments.png" class="pull-left" />
							<h5 class="pull-left comments-toggle"><a href="#">hide comments</a></h5>
						</div>
					</div>
				</div>

				<div class="comments">
					<div class="row comment">
						<div class="col-sm-2 text-center">
							<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_5.jpg" />
						</div>
						<div class="col-sm-10 comment-text">
							<p><a class="username" href="#">sergey</a> <span class="text-muted small pull-right">May 20, 2013 at 7:45am</span></p>
							<p class="small">This is awful and robratterman sucks!</p>
							<p class="small"><a href="#">Reply</a></p>
						</div>
					</div>
					<div class="row comment">
						<div class="col-sm-2 col-sm-offset-2">
							<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_4.jpg" />
						</div>
						<div class="col-sm-8 comment-text">
							<p><a class="username" href="#">robert-bobert</a> <span class="text-muted small pull-right">May 21, 2013 at 3:10am</span></p>
							<p class="small">Yeah, this guy is just nuts!</p>
						</div>
					</div>
					<div class="row comment">
						<div class="col-sm-2 col-sm-offset-2">
							<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_3.jpg" />
						</div>
						<div class="col-sm-8 comment-text">
							<p><a class="username" href="#">robratterman</a> <span class="text-muted small pull-right">May 21, 2013 at 3:12am</span></p>
							<p class="small">YOU BOTH ARE FIRED!!!</p>
						</div>
					</div>
				</div>
			</div>

			<h4 class="recitations-header">poemz recitations</h4>
			<div class="recitations">
				<div class="row">
					<div class="col-sm-2 text-center">
						<h5 class="index">1</h5>
					</div>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default active listen">Playing...</button>
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
										<a href="#">hide comments</a>
									</nobr>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="comments">
					<div class="row comment">
						<div class="col-sm-2 text-center">
							<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_5.jpg" />
						</div>
						<div class="col-sm-10 comment-text">
							<p><a class="username" href="#">sergey</a> <span class="text-muted small pull-right">May 20, 2013 at 7:45am</span></p>
							<p class="small">This is awful and robratterman sucks!</p>
							<p class="small"><a href="#">Reply</a></p>
						</div>
					</div>
					<div class="row comment">
						<div class="col-sm-2 col-sm-offset-2">
							<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_4.jpg" />
						</div>
						<div class="col-sm-8 comment-text">
							<p><a class="username" href="#">robert-bobert</a> <span class="text-muted small pull-right">May 21, 2013 at 3:10am</span></p>
							<p class="small">Yeah, this guy is just nuts!</p>
						</div>
					</div>
					<div class="row comment">
						<div class="col-sm-2 col-sm-offset-2">
							<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_3.jpg" />
						</div>
						<div class="col-sm-8 comment-text">
							<p><a class="username" href="#">robratterman</a> <span class="text-muted small pull-right">May 21, 2013 at 3:12am</span></p>
							<p class="small">YOU BOTH ARE FIRED!!!</p>
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
