<?
/**
 * @var  SiteController  $this
 * @var  Poem            $poem
 */
?>
<div class="container poem-page" data-controller="poem">
	<div class="row">
		<div class="col-sm-6 nice-scroll">
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
			<div class="recording-fade">
				<div>
					<button type="button" class="btn btn-primary btn-lg record-now">Record your version now!</button>
				</div>
				<br/>
				<div>
					<img src="<?= Yii::app()->baseUrl ?>/assets/img/comments.png" class="pull-left" />
					<h5 class="pull-left comments-toggle"><a href="#" class="toggle-comments" data-count="2">2 comments</a></h5>
				</div>
				<div class="clearfix"></div>
				<div class="comments hide-light">
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
					<div class="row">
						<div class="col-sm-12">
							<input type="text" placeholder="Post your comment here" class="form-control" />
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 nice-scroll">
			<div class="recording-fade">

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
								<h5 class="pull-left comments-toggle"><a href="#" class="toggle-comments" data-count="3">3 comments</a></h5>
							</div>
						</div>
					</div>

					<div class="comments hide-light">
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
						<div class="row">
							<div class="col-sm-12">
								<input type="text" placeholder="Post your comment here" class="form-control" />
							</div>
						</div>
					</div>
				</div>
				<h4 class="recitations-header">poemz recitations</h4>
				<div class="recitations">
					<div class="recitation">
						<div class="row">
							<div class="col-sm-1">
								<h5 class="index">1</h5>
							</div>
							<div class="col-sm-2">
								<button type="button" class="btn btn-default active listen">Playing...</button>
							</div>
							<div class="col-sm-2">
								<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_3.jpg" />
							</div>
							<div class="col-sm-7">
								<div class="info">
									<div class="username"><a href="#">robratterman</a></div>
									<div class="row">
										<div class="col-sm-6">
											<nobr><img src="<?= Yii::app()->baseUrl ?>/assets/img/thumb_up.png"/> 42 votes</nobr>
										</div>
										<div class="col-sm-6 text-right">
											<nobr>
												<img src="<?= Yii::app()->baseUrl ?>/assets/img/comments_sm.png"/>
												<a href="#" data-count="3" class="toggle-comments">3 comments</a>
											</nobr>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="comments hide-light">
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
							<div class="row">
								<div class="col-sm-12">
									<input type="text" placeholder="Post your comment here" class="form-control" />
								</div>
							</div>
						</div>
					</div>
					<div class="recitation">
						<div class="row">
							<div class="col-sm-1">
								<h5 class="index">2</h5>
							</div>
							<div class="col-sm-2">
								<button type="button" class="btn btn-default listen">Listen</button>
							</div>
							<div class="col-sm-2">
								<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_4.jpg" />
							</div>
							<div class="col-sm-7">
								<div class="info">
									<div class="username"><a href="#">robert-bobert</a></div>
									<div class="row">
										<div class="col-sm-6">
											<nobr><img src="<?= Yii::app()->baseUrl ?>/assets/img/thumb_up.png"/> 42 votes</nobr>
										</div>
										<div class="col-sm-6 text-right">
											<nobr>
												<img src="<?= Yii::app()->baseUrl ?>/assets/img/comments_sm.png"/>
												<a href="#" class="toggle-comments" data-count="3">3 comments</a>
											</nobr>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="comments hide-light">
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
							<div class="row">
								<div class="col-sm-12">
									<input type="text" placeholder="Post your comment here" class="form-control" />
								</div>
							</div>
						</div>
					</div>
					<div class="recitation">
						<div class="row">
							<div class="col-sm-1">
								<h5 class="index">3</h5>
							</div>
							<div class="col-sm-2">
								<button type="button" class="btn btn-default listen">Listen</button>
							</div>
							<div class="col-sm-2">
								<img class="thumbnail" src="<?= Yii::app()->baseUrl ?>/assets/img/portrait_placeholder_5.jpg" />
							</div>
							<div class="col-sm-7">
								<div class="info">
									<div class="username"><a href="#">sergey</a></div>
									<div class="row">
										<div class="col-sm-6">
											<nobr><img src="<?= Yii::app()->baseUrl ?>/assets/img/thumb_up.png"/> 42 votes</nobr>
										</div>
										<div class="col-sm-6 text-right">
											<nobr>
												<img src="<?= Yii::app()->baseUrl ?>/assets/img/comments_sm.png"/>
												<a href="#" class="toggle-comments" data-count="3">3 comments</a>
											</nobr>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="comments hide-light">
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
							<div class="row">
								<div class="col-sm-12">
									<input type="text" placeholder="Post your comment here" class="form-control" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="recorder panel panel-default hide-light" data-controller="recorder">
				<div class="panel-body">
					<div class="step1 text-center">
						<button type="button" class="btn btn-primary btn-lg start-recording">Start recording</button>
						<h3 class="recorder-separator">or</h3>
						<button type="button" class="btn btn-default btn-lg">Upload a file</button>
					</div>
					<div class="step2 hide-light text-center">
						<h4>Recording will start in</h4>
						<div class="big-number countdown">10</div>
						<button type="button" class="btn btn-default btn-lg">Cancel recording</button>
					</div>
					<div class="step3 hide-light text-center">
						<h4>Recording in progress</h4>
						<div class="big-number">00:00</div>
						<div>
							<button type="button" class="btn btn-primary btn-lg">Finish &amp; Save</button>
							<button type="button" class="btn btn-default btn-lg">Cancel &amp; Discard</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
