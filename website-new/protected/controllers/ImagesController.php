<?php
/**
 * ImagesController class
 *
 * @package  CanDo.Poemz.Controllers
 */
class ImagesController extends PageController
{
	/**
	 * Page
	 *
	 * @return  void
	 */
	public function actionIndex($image_id)
	{
		/**
		 * @var  Image  $image
		 */
		$image = Image::model()->findByPk($image_id);

		if ($image == null)
		{
			$this->redirect(Yii::app()->baseUrl . '/assets/img/grey_placeholder.jpg');
		}
		else
		{
			header('Content-Type: image/jpeg');
			file_put_contents('php://output', $image->content);
			exit();
		}
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
