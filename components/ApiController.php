<?php

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class ApiController extends Controller
{

	public function __construct($id, $module, $config = [])
	{
		$this->enableCsrfValidation = false;
		return parent::__construct($id, $module, $config = []);
	}

	public function sendResponse($status = 200, $body = '', $contentType = 'application/json')
	{
		$response = Yii::$app->response;
		$response->statusCode = $status;
		$response->format = \yii\web\Response::FORMAT_JSON;
		$response->data = $body;
		$response->send();
		Yii::$app->end();
	}  
	
}

