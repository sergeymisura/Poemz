<?php
/**
 * @var  SiteController  $this
 * @var  Author          $author
 */
?>
<div class="container author-page" data-controller="author">
	<div class="row">

		<!-- Left side -->
		<div class="col-sm-6">

			<div class="row">
				<div class="col-sm-3">
					<img class="thumbnail full-width" src="<?= $author->avatar->url ?>"/>
				</div>
				<div class="col-sm-9">
					<h3><?= $this->text($author->name) ?></h3>
				</div>
			</div>

			<div class="wiki" data-template="wiki">
				<div>{{html wiki_excerpt }}</div>
				<p class="small text-right"><a href="${ wiki_url }" target="_blank">more on Wikipedia</a></p>
			</div>
			<div class="wiki-loading loading hide-light"></div>

		</div>
		<!-- /Left side -->

		<!-- Right side -->
		<div class="col-sm-6">
			<ul class="nav nav-tabs nav-right nav-small order">
<!--				<li><a href="#" data-sort="new">Newest</a></li>
				<li><a href="#" data-sort="polpular">Most popular</a></li>  -->
				<li class="active"><a href="#" data-sort="first_line">By first line</a></li>
				<li><a href="#" data-sort="title">By title</a></li>
			</ul>

			<div class="letters text-justify">
				<span class="letters-container" data-template="letters">
					{{each letters }}
						{{if active }}
							<a href="#letter-${ letter }">${ letter }</a>
						{{else}}
							<span>${ letter }</span>
						{{/if}}
					{{/each}}
				</span>
				<span class="final"></span>
			</div>

			<div class="row poems" data-template="poems">
				{{each columns}}
					<div class="col-sm-6">
						{{each $value}}
							{{if isHeader }}
								<h3 class="section-header"><a id="${ link }">${ text }</a></h3>
							{{else}}
								<h5 class="title"><a href="${ app.urls.poem($value, app.data.author) }">${ title }</a></h5>
								<div class="first-line">${ first_line }</div>
							{{/if}}
						{{/each}}
					</div>
				{{/each}}
			</div>
		</div>
		<!-- /Right side -->
	</div>
</div>
