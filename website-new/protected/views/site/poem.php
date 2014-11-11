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
				<div class="col-sm-3 col-xs-4">
					<img class="thumbnail full-width" src="<?= $poem->author->avatarUrl ?>"/>
				</div>
				<div class="col-sm-9 col-xs-8">
					<h3 class="view no-margins-xs"><?= $this->text($poem->title) ?></h3>
					<h3 class="edit"><input type="text" class="form-control poem-title-control" value="<?= $this->text($poem->title) ?>" data-required="value" /></h3>
					<div>by <a href="<?= $this->createUrl('site/author', array('author_slug' => $poem->author->slug)) ?>"><?= $this->text($poem->author->name) ?></a></div>
					<br/>
					<div>
						<a class="btn-icon btn-toggle-edit" href="#" title="Edit the text of the poem" data-permission="poem:edit">
							<i class="fa fa-pencil-square-o"></i>
						</a>
						<!--
						<a class="btn-icon" href="#" title="Watch for the new recitations of this poem">
							<i class="fa fa-eye"></i>
						</a>
						<a class="btn-icon" href="#" title="Go to the comments">
							<i class="fa fa-comments-o"></i>
						</a>
						<a class="btn-icon" href="#" title="Flag the content as inappropriate or incorrect">
							<i class="fa fa-flag-o"></i>
						</a>
						-->
					</div>
				</div>
			</div>
			<div class="poem-text view"><?= $this->text($poem->poem_text->text) ?></div>
			<div class="edit">
				<textarea class="form-control poem-text-control" name="text" data-required="value"><?= $this->text($poem->poem_text->text) ?></textarea>
				<br/>
				<div>
					<button class="btn btn-primary btn-save-poem">Save</button>
					<button class="btn btn-default btn-reset">Reset</button>
				</div>
			</div>
			<br/>
			<div class="recording-fade view hidden-xs">
				<div>
					<button type="button" class="btn btn-primary btn-lg record-now">Record your version now!</button>
				</div>
				<br/>
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
								<h4><a href="${ app.urls.user(performer) }">${ performer.username }</a></h4>
								<div>
									<a class="btn-icon delete-link" data-id="${ id }" data-permission="recitation:delete" href="#" title="Delete this recitation">
										<i class="fa fa-times"></i>
									</a>
									<a class="btn-icon vote-link" data-id="${ id }" data-action="vote" href="#" title="Vote for this recitation">
										<i class="fa fa-thumbs-o-up"></i> <span>${ votes }</span>
									</a>
								</div>
							</div>
						</div>
						<div class="player"><audio data-src="${ media }" style="width: 100%"/></div>
						<div class="alert alert-danger vote-error hide-light"></div>
						<!--
						<div class="row">
							<div class="col-sm-6">
								<h5><a href="#" class="vote-link" data-action="vote">Vote!</a> (${ votes } people voted so far)</h5>
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
						-->

						<div class="comments hide-light" data-controller="poem-comments" data-topic="${ topic }">
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

				<div class="recitations" data-controller="recitations" data-source="poems/<?= $poem->id ?>/recitations">
					<div class="recitations-header">
						<h4 class="pull-left">poemz recitations</h4>
						<br class="visible-xs"/><br class="visible-xs"/>
						<ul class="nav nav-tabs nav-right nav-small order">
							<li><a href="#" data-sort="new">Newest</a></li>
							<li class="active"><a href="#" data-sort="best">The best</a></li>
						</ul>
					</div>
					<div class="recitation-template hide">
						<div class="recitation" data-template="recitation">
							<div class="row row-hover">
								<div class="col-sm-2">
									<img class="img-thumbnail img-responsive" data-src="${ performer.avatar }" />
								</div>
								<div class="col-sm-5">
									<h4><a href="${ app.urls.user(performer) }">${ performer.username }</a></h4>
									<p class="text-muted">Recorded ${ ago }</p>
								</div>
								<div class="col-sm-2"></div>
								<div class="col-sm-3 text-right">
									<br/>
									<a class="btn-icon-lg delete-link" data-id="${ id }" data-permission="recitation:delete" href="#" title="Delete this recitation">
										<i class="fa fa-times"></i>
									</a>
									<a href="#" class="btn-icon-lg vote-link" data-id="${ id }" data-action="vote" title="Vote for this recitation">
										<i class="fa fa-thumbs-o-up"></i> <span>${ votes }</span>
									</a>
									<!--
									<a href="#" class="btn-icon" title="Toggle the comments section">
										<i class="fa fa-comments-o"></i> ${ (topic ? topic.comments_count : 0) }
									</a>
									<a href="#" class="btn-icon" title="Add to the list of your favorites">
										<i class="fa fa-star-o"></i>
									</a>-->
								</div>
						<!--		<div class="col-sm-1">
									<h5 class="index">${ index($data) + 1 }</h5>
								</div>
								<div class="col-sm-2">
									<button type="button" class="btn btn-default listen" data-index="${ index($data) }">Listen</button>
								</div>
								<div class="col-sm-2">
									<img class="thumbnail" data-src="${ performer.avatar }" />
								</div>
								<div class="col-sm-4 text-column">
									<div class="username"><a href="${ app.urls.user(performer) }">${ performer.username }</a></div>
								</div>
								<div class="col-sm-3 text-column text-right">
									<a class="btn-icon delete-link" data-id="${ id }" data-permission="recitation:delete" href="#" title="Delete this recitation">
										<i class="fa fa-times"></i>
									</a>
									<a href="#" class="btn-icon vote-link" data-id="${ id }" data-action="vote" title="Vote for this recitation">
										<i class="fa fa-thumbs-o-up"></i> <span>${ votes }</span>
									</a>
									<!--
									<a href="#" class="btn-icon" title="Toggle the comments section">
										<i class="fa fa-comments-o"></i> ${ (topic ? topic.comments_count : 0) }
									</a>
									<a href="#" class="btn-icon" title="Add to the list of your favorites">
										<i class="fa fa-star-o"></i>
									</a>
									- ->
								</div>-->
							</div>
						</div>
					</div>

					<br/>

					<div class="alert alert-warning hide-light no-recordings">
						No one has recorded this poem yet! Be the first!
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
						<span class="btn btn-default btn-lg fileinput-button">
							<span>Upload .mp3 file</span>
							<input class="cover-upload" type="file" name="content"/>
						</span>
                        <hr/>
                        <a class="cancel-step1" href="#">or click here to cancel.</a>
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
						<h4>Please wait while we upload your record...</h4>
						<div class="progress">
							<div class="progress-bar" style="width:0"></div>
						</div>
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
