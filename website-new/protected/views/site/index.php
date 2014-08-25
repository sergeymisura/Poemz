<div class="container front-page">
	<h2 class="tag-line text-center text-primary">Let the world hear your favorite poem...</h2>
	<h4 class="tag-line text-center">and hear others' interpretations of your favorites.</h4>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#">Best stuff ever</a></li>
		<li><a href="#">Your favorites</a></li>
		<li><a href="#">Random</a></li>
	</ul>

	<br/>

	<div class="row" data-controller="front-poems">
		<div class="col-sm-2" data-template="poem">
			<div><img data-src="${ app.urls.image(author.avatar_id) }" class="img-responsive img-thumbnail" /></div>
			<div class="poem-info">
				<h5 class="title text-primary"><a href="${ app.urls.poem($data) }">${ title }</a></h5>
				<div>by <a href="${ app.urls.author(author) }">${ author.name }</a></div>
				<div class="first-line">${ first_line }</div>
			</div>
			<div class="read-by">
				<div>#1 read by <a href="#">robratterman</a></div>
				<div>#2 read by <a href="#">bobert</a></div>
			</div>
			<h6 class="text-center"><a href="#">Hear more versions</a></h6>
			<div><button class="btn btn-primary btn-xs record-own">Record your version</button></div>
		</div>
	</div>

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
