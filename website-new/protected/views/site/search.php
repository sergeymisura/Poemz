<?php
/**
 * @var  SiteController  $this
 * @var  Author[]        $authors
 * @var  Poem[]          $poems
 * @var  integer         $idx
 */
?>

<div class="container">
	<h3>Search results for "<?= $this->text($this->request->getQuery('q', '')) ?>"</h3>
	<br/>
	<?php if (count($authors) > 0): ?>
		<div class="row">
			<?php $idx = 0; foreach ($authors as $author): $idx++; ?>
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
				<?php if ($idx % 6 == 0): ?></div><div class="row"><?php endif; ?>
			<?php endforeach; ?>
		</div>
		<br/>
	<?php endif; ?>
	<?php if (count($poems) > 0): ?>
		<div class="row">
			<?php $idx = 0; foreach ($poems as $poem): $idx++; ?>
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
				<?php if ($idx % 3 == 0): ?></div><div class="row"><?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
