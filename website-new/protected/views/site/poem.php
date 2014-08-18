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
					<img class="thumbnail full-width" src="<?= $poem->author->avatar->url ?>"/>
				</div>
				<div class="col-sm-9">
					<h3><?= $this->text($poem->title) ?></h3>
					<div>by <a href="<?= $this->createUrl('site/author', array('author_slug' => $poem->author->slug)) ?>"><?= $this->text($poem->author->name) ?></a></div>
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

				<div class="alert alert-success hide-light recitation-created">
					Congratulations! Your recitation has been created. Let's wait and see what others think of your performance.
				</div>

				<div class="now-playing hide-light" data-controller="poem-now-playing">
					<div class="well" data-template="now-playing">
						<h4>Now playing</h4>
						<div  class="row">
							<div class="col-sm-3">
								<img class="thumbnail" data-src="${ performer.avatar }" />
							</div>
							<div class="col-sm-9 recited-by">
								<div>recited by</div>
								<h4><a href="#">${ performer.username }</a></h4>
							</div>
						</div>
						<div class="player"><audio data-src="${ media }" style="width: 100%"/></div>
						<div class="row">
							<div class="col-sm-6">
								<h5><a href="#">Vote!</a></h5>
							</div>
							<div class="col-sm-6">
								<div class="pull-right">
									<h5 class="pull-left comments-toggle">
										<a href="#" class="toggle-comments" data-count="${ topic ? topic.comments_count : 0 }">
											${ topic ? topic.comments_count : 0 } comments
										</a>
									</h5>
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

				<div class="recitations" data-controller="poem-recitations">
					<div class="recitations-header">
						<h4 class="pull-left">poemz recitations</h4>

						<ul class="nav nav-tabs nav-right nav-small order">
							<li class="active"><a href="#" data-sort="new">Newest</a></li>
							<li><a href="#" data-sort="best">The best</a></li>
						</ul>
					</div>
					<div class="recitation-template hide">
						<div class="recitation" data-template="recitation">
							<div class="row">
								<div class="col-sm-1">
									<h5 class="index">${ index($data) + 1 }</h5>
								</div>
								<div class="col-sm-2">
									<button type="button" class="btn btn-default listen" data-index="${ index($data) }">Listen</button>
								</div>
								<div class="col-sm-2">
									<img class="thumbnail" data-src="${ performer.avatar }" />
								</div>
								<div class="col-sm-7">
									<div class="info">
										<div class="username"><a href="#">${ performer.username }</a></div>
										<div class="row">
											<div class="col-sm-6">
												<nobr>${ votes } votes</nobr>
											</div>
											<div class="col-sm-6 text-right">
												<nobr>
													<a href="#" data-count="${ (topic ? topic.comments_count : 0) }" class="toggle-comments">
														${ (topic ? topic.comments_count : 0) } comments
													</a>
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

					<br/>

					<div class="alert alert-warning hide-light no-recordings">
						No one have recorded this poem yet! Be the first!
					</div>
					<div class="recitation-list"></div>

					<div class="loading"></div>

					<div class="more"><span class="pull-right more-tab">more</span></div>
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
						<h4>Please allow us to use your microphone...</h4>
					</div>
					<div class="step3 hide-light text-center">
						<h4>Recording in progress</h4>
						<div class="big-number timer">00:00</div>
						<div>
							<button type="button" class="btn btn-primary btn-lg finish-recording">Finish &amp; Save</button>
							<button type="button" class="btn btn-default btn-lg cancel-recording">Cancel &amp; Discard</button>
						</div>
					</div>
					<div class="step4 hide-light text-center">
						<h4>Please wait while we are uploading your record...</h4>
					</div>
					<div class="step5 hide-light text-center">
						<h4>Review your performance</h4>
						<br/>
						<div class="preview-container"></div>
						<br/>
						<div>
							<button type="button" class="btn btn-primary btn-lg keep-recording">Perfect, keep it!</button>
							<button type="button" class="btn btn-default btn-lg try-again-recording">Discard &amp; try again...</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
