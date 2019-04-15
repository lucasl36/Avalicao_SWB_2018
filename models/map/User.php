<?php

namespace app\models\map;

use Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use app\models\db\User as DbUser;
use app\models\form\User as FormUser;

class User
{

	public static function requestToForm($request)
	{
		$model = new FormUser();
		$model->id = isset($request['id']) ? $request['id'] : null;
		$model->name = $request['name'];
		$model->login = $request['login'];
		$model->password = $request['password'];
		return $model;
	}

	public static function formToDb($formModel)
	{
		$model = new DbUser();
		$model->id = !empty($formModel->id) ? $formModel->id : null;
		$model->login = $formModel->login;
		$model->password = $formModel->password;
		$model->name = $formModel->name;
		return $model;
	}

	public static function updateDbModel($formModel, $dbModel)
	{
		$password = $dbModel->password;
		foreach($dbModel->attributes as $attr => $value)
		{
			$dbModel->$attr = $dbModel->$attr == $formModel->$attr ? 
			$dbModel->$attr : 
			$formModel->$attr;
		}
		if(Yii::$app->getSecurity()
		   ->validatePassword($dbModel->password, $password))
		{
			$dbModel->password = $password;
		}else
		{
			$dbModel->password = Yii::$app->getSecurity()
			->generatePasswordHash($dbModel->password);
		}	
		return $dbModel;
	}

	public static function filterToForm($filter)
	{
		$model = new FormUser();
		$model->login = !empty($filter['login']) ? $filter['login'] : null;
		$model->name = !empty($filter['name']) ? $filter['name'] : null;
		return $model;
	}

	public static function dbToResponse($dbModelList)
	{
		$resultArr;
		foreach($dbModelList as $model)
		{
			foreach($model->attributes as $attr => $value)
			{
				$resultArr[$model->id][$attr] = $value;
			}
		}
		return $resultArr;
	}

	public static function requestLoginToForm($request)
	{
		$model = new FormUser();
		$model->login = $request['login'];
		$model->password = $request['password'];
		return $model;
	}

	public static function dbToLoginResponse($dbModel)
	{
		$responseArr;
		foreach($dbModel->attributes as $attr => $value)
		{
			$responseArr[$dbModel->id][$attr] = $value;
		}
		return $responseArr;
	}

}
