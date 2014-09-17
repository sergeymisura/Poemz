<?php
/**
 * @var  SiteController  $this
 * @var  Author[]        $authors
 * @var  Poem[]          $poems
 */
?>

<div class="container">
	<h3>Search results for "<?= $this->text($this->request->getQuery('q', '')) ?>"</h3>
	<br/>
	<?php if (count($authors) > 0): ?>
		<div class="row">
			<?php foreach ($authors as $author) :?>
				<div class="col-sm-2">
					<div>
						<a href="<?= $this->createUrl('site/author', array('author_slug' => $author->slug)) ?>">
							<img src="<?= $author->avatarUrl ?>" class="img-responsive img-thumbnail" />
						</a>
					</div>
					<h5>
						<a href="<?= $this->createUrl('site/author', array('author_slug' => $author->slug)) ?>">
							<?= $this->text($author->name) ?>
						</a>
					</h5>
				</div>
			<?php endforeach; ?>
		</div>
		<br/>
	<?php endif; ?>
	<?php if (count($poems) > 0): ?>
		<div class="row">
			<?php foreach ($poems as $poem): ?>
				<div class="col-sm-4 search-result-poem">
					<div class="pull-left">
						<img class="img-thumbnail img-th-small" src="<?= $poem->author->avatarUrl ?>" />
					</div>
					<div class="search-result-poem-info" >
						<h5 class="title">
							<a href="<?= $this->createUrl('site/poem', array('author_slug' => $poem->author->slug, 'poem_slug' => $poem->slug)) ?>">
								<?= $this->text($poem->title) ?>
							</a>
							by
							<a href="<?= $this->createUrl('site/author', array('author_slug' => $poem->author->slug)) ?>">
								<?= $this->text($poem->author->name) ?>
							</a>
						</h5>
						<div class="first-line"><?= $this->text($poem->first_line) ?></div>
						<br/>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
