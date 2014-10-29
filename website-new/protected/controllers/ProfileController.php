<?php
class ProfileController extends PageController
{
    public function actionIndex($slug)
    {
        /**
         * @var  User  $user
         */
        $user = User::model()->findByAttributes(['slug' => $slug]);

        if ($user == null)
        {
            $this->notFound();
        }

        $this->setPageData('user', $user);

        $this->render('index', ['user' => $user]);
    }

    public function actionEdit($slug)
    {
        /**
         * @var  User  $user
         */
        $user = User::model()->findByAttributes(['slug' => $slug]);

        if ($user == null)
        {
            $this->notFound();
        }

        if ($this->session == null || $this->session->user_id != $user->id)
        {
            $this->authFailed();
        }

        $this->setPageData('user', $user);

        $this->render('edit', ['user' => $user]);
    }
}