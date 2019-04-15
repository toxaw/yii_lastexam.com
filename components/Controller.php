<?php
namespace app\components;

use Yii;

class Controller extends \yii\web\Controller
{
	public function beforeAction($action)
	{
		//die('lolka_igolka');

		return true;
	}
}