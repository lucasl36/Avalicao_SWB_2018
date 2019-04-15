<?php

namespace app\models\map;

use Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use app\models\db\People as DbPeople;
use app\models\form\People as FormPeople;

class People
{

	public static function requestToForm($request)
	{
		$model = new FormPeople();
		$model->id = isset($request['id']) ? $request['id'] : null;
		$model->name = $request['name'];
		$model->cpfcnpj = $request['cpfcnpj'];
		$model->rgie = $request['rgie'];
		$model->people_type = $request['people_type'];
		$model->mail_address = $request['mail_address'];
		$model->phone = $request['phone'];
		$model->cell_phone = $request['cell_phone'];
		$model->birth = isset($request['birth']) ? 
		$request['birth'] : 
		null;
		$model->employess_amount = isset($request['employess_amount']) ? 
		$request['employess_amount'] : 
		null;
		return $model;
	}

	public static function formToDb($formModel)
	{
		$model = new DbPeople();
		$model->id = !empty($formModel->id) ? $formModel->id : null;
		$model->name = $formModel->name; 
		$model->cpfcnpj = $formModel->cpfcnpj;
		$model->rgie = $formModel->rgie;
		$model->people_type = $formModel->people_type;
		$model->mail_address = $formModel->mail_address;
		$model->phone = $formModel->phone;
		$model->cell_phone = $formModel->cell_phone;
		$model->birth = !empty($formModel->birth) ? 
		$formModel->birth : 
		null;
		$model->employess_amount = !empty($formModel->employess_amount) ? 
		$formModel->employess_amount : 
		null;
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
		$model = new FormPeople();
		$model->name = !empty($filter['name']) ? $filter['name'] : null;
		$model->cpfcnpj = !empty($filter['cpfcnpj']) ? $filter['cpfcnpj'] : null;
		$model->rgie = !empty($filter['rgie']) ? $filter['rgie'] : null;
		$model->people_type = !empty($filter['people_type']) ? $filter['people_type'] : null;
		$model->mail_address = !empty($filter['mail_address']) ? $filter['mail_address'] : null;
		$model->phone = !empty($filter['phone']) ? $filter['phone'] : null;
		$model->cell_phone = !empty($filter['cell_phone']) ? $filter['cell_phone'] : null;
		$model->birth = !empty($filter['birth']) ? $filter['birth'] : null;
		$model->employess_amount = !empty($filter['employess_amount']) ? $filter['employess_amount'] : null;
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

}
