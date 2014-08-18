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

			<!-- Author's info -->
			<div class="row">
				<div class="col-sm-3">
					<img class="thumbnail full-width" src="<?= $author->avatar->url ?>"/>
				</div>
				<div class="col-sm-9">
					<h3><?= $this->text($author->name) ?></h3>
					<br/>
					<div class="wiki" data-template="wiki">
						<div>{{html wiki_excerpt }}</div>
						<p class="small text-right"><a href="${ wiki_url }">more on Wikipedia</a></p>
					</div>
					<div class="wiki-loading loading hide-light"></div>
				</div>
			</div>
			<!-- /Author's info -->

		</div>
		<!-- /Left side -->
	</div>
</div>
