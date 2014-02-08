<?php
/**
 * SiteController class
 *
 * @package  CanDo.Poemz.Controllers
 */
class SiteController extends PageController
{
	/**
	 * Page
	 *
	 * @return  void
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
}
