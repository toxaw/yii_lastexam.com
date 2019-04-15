<?php
namespace app\components;

use yii\web\NotFoundHttpException;

use Yii;

class Controller extends \yii\web\Controller
{
	public function beforeAction($action)
	{
		$admin = [];

		$user = [];

		$guest = [];

		$admin['site'] = ['index', 'logout', 'error'];

		$admin['claim'] = ['allclaim','edit'];

		$admin['category'] = [];

		$user['site'] = ['index', 'logout', 'error'];

		$user['claim'] = ['myclaim','add'];

		$guest['site'] = ['index', 'login','registr', 'error'];

		$c = Yii::$app->controller->id;

		$a = Yii::$app->controller->action->id;

		if(!Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin) 
        {
        	if(isset($admin[$c]) && ( !$admin[$c] || in_array($a, $admin[$c])))
        	{
        		return true;
        	}
        }
        else if (!Yii::$app->user->isGuest)
        {
        	if(isset($user[$c]) && ( !$user[$c] || in_array($a, $user[$c])))
        	{
        		return true;
        	}
        }
        else
        {
        	if(isset($guest[$c]) && ( !$guest[$c] || in_array($a, $guest[$c])))
        	{
        		return true;
        	}
        }

		Yii::$app->getResponse()->redirect('basic/site/error')->send();

		return false;
	}
}