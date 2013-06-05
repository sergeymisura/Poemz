<?php
/**
 * Miscellaneous pages
 * 
 * @package  Canvassing.Controllers
 */
class PagesController extends PageController
{
	/**
	 * Main page
	 * 
	 * @return  void
	 */
	public function actionPoem($id)
	{
		$poem = Poem::model()->findByPk($id);
		$poem->getRelated('author');
		$poem->getRelated('latest');
		$this->setPageData('poem', $poem);
		$this->render('poem');
	}
}
