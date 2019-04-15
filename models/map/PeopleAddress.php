<?php

namespace app\models\map;

use Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use app\models\db\PeopleAddress as DbPeopleAddress;

class PeopleAddress
{

	public static function toDb($address_id, $people_id)
	{
		$model = new DbPeopleAddress();
		$model->people_id = $people_id;
		$model->address_id = $address_id;
		return $model;
	}

}
