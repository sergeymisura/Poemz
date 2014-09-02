<?php
/**
 * @var  SiteController  $this
 */
?>
<div class="container new-page" data-controller="new">
	<div class="row">

		<!-- Author -->
		<div class="col-sm-6 step-1" data-controller="new-author">
			<h2>Step 1. Find the author.</h2>

			<!-- Author search -->
			<div class="row author-finder" data-controller="selector">
				<div class="col-sm-3">
					<img class="author-avatar thumbnail full-width" src="<?= Yii::app()->baseUrl ?>/assets/img/mystery_man.png"/>
				</div>
				<div class="col-sm-9">
					<p><input type="text" class="input-query form-control" /></p>
					<div class="results-area">
						<p class="alert alert-warning start-message">Please start typing the author's name and then pick the author from the list.</p>
						<div class="loading hide-light"></div>
						<div class="objects-list authors-list hide-light">
							<ul class="nav nav-pills nav-stacked">
								<li class="author" data-template="select-object">
									<a href="#" class="h4 select-object">
										<img class="thumbnail" style="width: 50px" data-src="${ app.urls.image(avatar_id) }"/>
										${ name }
									</a>
								</li>
							</ul>
						</div>
						<div class="no-matches hide-light alert alert-danger">
							<p>We cannot find any matching authors in our database.</p>
							<p data-template="add-object">
								<button type="button"
										class="btn btn-primary btn-add-new"
										data-name="${ name }"
										data-loading-text="Adding ${ name }...">Add ${ name } as a new author</button>
							</p>
						</div>
					</div>
				</div>
			</div>
			<!-- /Author search -->

			<div class="selected-author hide-light" data-template="selected-author">
				<div class="row">
					<div class="col-sm-3">
						<img class="thumbnail full-width" data-src="${ app.urls.image(avatar_id) }"/>
					</div>
					<div class="col-sm-9">
						<h3>${ name }</h3>
					</div>
				</div>

				{{if wiki_url }}
					<div class="wiki">
						<div>{{html wiki_excerpt }}</div>
						<p class="small text-right"><a href="${ wiki_url }" target="_blank">more on Wikipedia</a></p>
					</div>
				{{/if}}
			</div>
		</div>
		<!-- /Author -->

		<!-- Poem -->
		<div class="col-sm-6 hide-light step-2" data-controller="new-poem">
			<h2>Step 2. Find the poem.</h2>
			<div class="poem-selector" data-controller="selector">
				<p><input type="text" class="input-query form-control" /></p>
				<div class="results-area">
					<p class="alert alert-warning start-message">Please start typing the poem's title or the first line and then pick the poem from the list.</p>
					<div class="loading hide-light"></div>
					<div class="objects-list poems-list hide-light">
						<div data-template="select-object">
							<h5 class="title"><a href="${ app.urls.poem($data, author()) }#record"">${ title }</a></h5>
							<div class="first-line">${ first_line }</div>
						</div>
						<br/>
					</div>
					<p class="have-more alert alert-warning hide-light">We have more matching poems, so keep typing...</p>
					<p class="add-new-poem hide-light" data-template="add-object">
						<button type="button" class="btn btn-primary btn-add-new" data-title="${ name }">Can't find the poem? Add it!</button>
					</p>
				</div>
			</div>
			<form class="new-poem-form hide-light">
				<div class="form-group">
					<label for="new-poem-title">Poem title:</label>
					<input type="text" class="form-control" id="new-poem-title" name="title" data-required="value"/>
				</div>
				<div class="form-group">
					<label for="new-poem-text">Poem text:</label>
					<textarea class="form-control" id="new-poem-text" name="text" data-required="value"></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary submit-poem">Submit the poem and start recording</button>
				</div>
			</form>
		</div>
		<!-- /Poem -->
	</div>
</div>

