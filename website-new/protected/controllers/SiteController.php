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

	public function actionLogout()
	{
		if ($this->session != null)
		{
			$this->session->delete();
		}
		$this->redirect($this->createUrl('site/index'));
	}
}
