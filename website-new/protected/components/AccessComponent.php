<?php
class AccessComponent extends CComponent
{
	public function init()
	{
	}

	public function can($permission, $user=null)
	{
		if ($user == null)
		{
			if (isset(Yii::app()->controller) && isset(Yii::app()->controller->session))
			{
				$user = Yii::app()->controller->session->user;
			}
		}
		if ($user == null)
		{
			return false;
		}

		/* TODO: Add caching and rules */

		return Yii::app()->db->createCommand()
			->select('count(*)')
			->from('role_permission rp')
			->leftJoin('user_role ur', 'rp.role_id = ur.role_id')
			->where('permission_id = :permission and user_id = :user', [':permission' => $permission, ':user' => $user->id])
			->queryScalar() > 0;
	}
}
