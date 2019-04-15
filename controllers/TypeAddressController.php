<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use app\components\ApiController;
use app\models\form\TypeAddress as FormTypeAddress;
use app\models\db\TypeAddress as DbTypeAddress;
use app\models\map\TypeAddress as TypeAddressMap;

class TypeAddressController extends ApiController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'update' => ['post'],
                    'delete' => ['get'],
                    'list' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }


    public function actionCreate()
    {
        $model = TypeAddressMap::requestToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        if(!$model->validate())
        {
            $this->sendResponse(500, $user->getErrors());
        }
        $record = TypeAddressMap::formToDb($model);
        try
        {
            $record->save();
            $this->sendResponse(200, '');
        }catch(Exception $e)
        {
            $this->sendResponse(500, $e->getMessage());
        }
    }

    public function actionUpdate()
    {
        $model = TypeAddressMap::requestToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        if(!$model->validate())
        {
            $this->sendResponse(500, $user->getErrors());
        }
        $record = DbTypeAddress::findOne($model->id);
        if(empty($record))
        {
            $this->sendResponse(500, 'Invalid User Id');
        }
        $record = TypeAddressMap::updateDbModel($model, $record);
        try
        {
            $record->save();
            $this->sendResponse(200, '');
        }catch(Exception $e)
        {
            $this->sendResponse(500, $e->getMessage());
        }
    }

    public function actionDelete($id)
    {
        $record = DbTypeAddress::findOne($id);
        if(empty($record))
        {
           $this->sendResponse(500, 'Invalid User Id'); 
        }
        try
        {
            $addresses = $record->getAddresses()->all();
            if(!empty($addresses))
            {
                $record->active = false;
                $record->save();
            }else
            {
                $record->delete();
            }
            $this->sendResponse(200, '');
        }catch(Exception $e)
        {
            $this->sendResponse(500, $e->getMessage());
        }
    }

    public function actionList()
    {
        $model = TypeAddressMap::filterToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        $records = DbTypeAddress::filter($model);
        if(empty($records))
        {
           $this->sendResponse(200, ''); 
        }
        $response = TypeAddressMap::dbToResponse($records);
        // Mapeamento do que for para o Angular
        $this->sendResponse(200, $response); 
    }

}
