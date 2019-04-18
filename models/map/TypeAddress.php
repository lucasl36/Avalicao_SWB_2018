<?php

namespace app\models\map;

use Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use app\models\db\TypeAddress as DbTypeAddress;
use app\models\form\TypeAddress as FormTypeAddress;

class TypeAddress
{

	public static function requestToForm($request)
	{
		$model = new FormTypeAddress();
		$model->id = isset($request['id']) ? $request['id'] : null;
		$model->name = $request['name'];
		$model->active = isset($request['active']) ? $request['active'] : null;
		return $model;
	}

	public static function formToDb($formModel)
	{
		$model = new DbTypeAddress();
		$model->id = !empty($formModel->id) ? $formModel->id : null;
		$model->name = $formModel->name;
		$model->active = $formModel->active;
		return $model;
	}

	public static function updateDbModel($formModel, $dbModel)
	{
		foreach($dbModel->attributes as $attr => $value)
		{
			$dbModel->$attr = $dbModel->$attr == $formModel->$attr ? 
			$dbModel->$attr : 
			$formModel->$attr;
		}	
		return $dbModel;
	}

	public static function filterToForm($filter)
	{
		$model = new FormTypeAddress();
		$model->name = !empty($filter['name']) ? $filter['name'] : null;
		if(isset($filter['active']))
		{
			$model->active = $filter['active'] == 1 || $filter['active'] == 0 ?
			$filter['active'] :
			null;

		}
		return $model;
	}

	public static function dbToResponse($dbModelList)
	{
		$resultArr = [];
		foreach($dbModelList as $model)
		{
			$modelArr = [];
			foreach($model->attributes as $attr => $value)
			{
				$modelArr[$attr] = $value;
			}
			$resultArr[] = $modelArr;
		}
		return $resultArr;
	}

}
