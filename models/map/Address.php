<?php

namespace app\models\map;

use Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use app\models\db\Address as DbAddress;
use app\models\form\Address as FormAddress;

class Address
{

	public static function requestToForm($request)
	{
		$model = new FormAddress();
		$model->setScenario(FormAddress::form_scenario); 
		$model->id = isset($request['id']) ? $request['id'] : null;
		$model->name = $request['name'];
		$model->active = $request['active'];
		$model->street_name = $request['street_name'];
		$model->number = $request['number'];
		$model->description = $request['description'];
		$model->complement = $request['complement'];
		$model->id_people = $request['id_people'];
		$model->id_type_address = $request['id_type_address'];
		return $model;
	}

	public static function formToDb($formModel)
	{
		$model = new DbAddress();
		$model->id = !empty($formModel->id) ? $formModel->id : null;
		$model->name = $formModel->name; 
		$model->active = $formModel->active;
		$model->street_name = $formModel->street_name;
		$model->number = $formModel->number;
		$model->description = $formModel->description;
		$model->complement = $formModel->complement;
		$model->id_type_address = $formModel->id_type_address;
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
		$model = new FormAddress();
		$model->setScenario(FormAddress::filter_scenario); 
		$model->name = !empty($filter['name']) ? $filter['name'] : null;
		if(isset($filter['active']))
		{
			$model->active = $filter['active'] == 1 || $filter['active'] == 0 ?
			$filter['active'] :
			null;

		}
		$model->street_name = !empty($filter['street_name']) ? $filter['street_name'] : null;
		$model->number = !empty($filter['number']) ? $filter['number'] : null;
		$model->description = !empty($filter['description']) ? $filter['description'] : null;
		$model->complement = !empty($filter['complement']) ? $filter['complement'] : null;
		$model->name_people = !empty($filter['name_people']) ? $filter['name_people'] : null;
		$model->id_type_address = !empty($filter['id_type_address']) ? $filter['id_type_address'] : null;
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
			$peoples = $model->getPeoples()->one();
			$modelArr['name_people'] = $peoples->name;
			$resultArr[] = $modelArr;
		}
		return $resultArr;
	}

}
