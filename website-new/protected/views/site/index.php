<div class="container front-page" data-controller="front-poems">
	<h2 class="tag-line text-center text-primary">Let the world hear your favorite poem...</h2>
	<h4 class="tag-line text-center">and hear others' interpretations of your favorites.</h4>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#" data-list="newest">Newest <span class="hidden-xs">recordings</span></a></li>
		<li><a href="#" data-list="best">Best <span class="hidden-xs">stuff ever</span></a></li>
		<li><a href="#" data-list="favorite">Your favorites</a></li>
		<li class="hidden-xs"><a href="#" data-list="random">Random</a></li>
	</ul>

	<br/>

	<div class="poems">
		<div class="row">
			<div class="col-sm-2" data-template="poem">
				<div class="hidden-xs">
					<div><img data-src="${ app.urls.image(author.avatar_id) }" class="img-responsive img-thumbnail" /></div>
					<div class="poem-info">
						<h5 class="title text-primary"><a href="${ app.urls.poem($data) }">${ title }</a></h5>
						<div>by <a href="${ app.urls.author(author) }">${ author.name }</a></div>
						<div class="first-line">${ first_line }</div>
					</div>
					<div class="read-by">
						{{each recitations(id)}}
						<div>#${ $index + 1 } by <a href="${ app.urls.poem($data) }#listen-${ id }">${ performer.username }</a></div>
						{{/each}}
					</div>
					<h6 class="text-center"><a href="${ app.urls.poem($data) }">Hear more versions</a></h6>
					<div><a href="${ app.urls.poem($data) }#record" class="btn btn-primary btn-xs record-own">Record your version</a></div>
				</div>
				<div class="visible-xs">
					<br/>
					<div class="row">
						<div class="col-xs-4"><img data-src="${ app.urls.image(author.avatar_id) }" class="img-responsive img-thumbnail" /></div>
						<div class="col-xs-8">
							<div class="poem-info">
								<h5 class="title text-primary"><a href="${ app.urls.poem($data) }">${ title }</a></h5>
								<div>by <a href="${ app.urls.author(author) }">${ author.name }</a></div>
								<div class="first-line">${ first_line }</div>
							</div>
						</div>
					</div>
					<div class="read-by">
						{{each recitations(id)}}
						<div>#${ $index + 1 } by <a href="${ app.urls.poem($data) }#listen-${ id }">${ performer.username }</a></div>
						{{/each}}
					</div>
					<div><a href="${ app.urls.poem($data) }" class="btn btn-primary full-width">Hear more versions</a></div>
					<br/>
				</div>
			</div>
		</div>
	</div>

	<div class="loading hide-light"></div>

	<br/>

	<div class="more">
		<span class="pull-right">more</span>
	</div>

	<br/>
	<br/>

	<div class="text-center">
		<a href="<?= $this->createUrl('site/new') ?>" class="btn btn-primary btn-lg record-now">Record your favorite poem now!</a>
	</div>

	<br/>
	<br/>
</div>
