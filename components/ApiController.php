<?php

namespace app\components;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\filters\Cors;

class ApiController extends Controller
{

	public function __construct($id, $module, $config = [])
	{
		$this->enableCsrfValidation = false;
		return parent::__construct($id, $module, $config = []);
	}

	public static function allowedDomains()
	{
		return [
			'http://localhost:4200'
		];
	}

	public function behaviors() {
		return array_merge(parent::behaviors(), [
			'corsFilter'  => [
				'class' => \yii\filters\Cors::className(),
				'cors'  => [
					'Origin'                           => self::allowedDomains(),
					'Access-Control-Request-Method'    => ['GET','POST'],
					'Access-Control-Allow-Credentials' => true,
					'Access-Control-Max-Age'           => 3600,                 
				],
			],

		]);
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

