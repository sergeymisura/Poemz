<?php
/**
 * Miscellaneous pages
 * 
 * @package  Canvassing.Controllers
 */
class SiteController extends PageController
{
	/**
	 * Main page
	 * 
	 * @return  void
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionWelcome()
	{
		$this->render('welcome');
	}

	public function actionSubmit()
	{
		$this->render('submit');
	}
}
