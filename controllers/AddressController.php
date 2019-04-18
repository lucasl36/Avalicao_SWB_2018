<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use app\components\ApiController;
use app\models\form\Address as FormAddress;
use app\models\db\Address as DbAddress;
use app\models\map\Address as AddressMap;
use app\models\map\PeopleAddress as PeopleAddressMap;

class AddressController extends ApiController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'update' => ['post'],
                    'delete' => ['get'],
                    'list' => ['post'],
                ],
            ],
        ]);
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
        $model = AddressMap::requestToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        if(!$model->validate())
        {
            $this->sendResponse(500, $user->getErrors());
        }
        $record = AddressMap::formToDb($model);
        try
        {
            $record->save();
            $paRecord = PeopleAddressMap::toDb($record->id, $model->id_people);
            $paRecord->save();
            $this->sendResponse(200, '');
        }catch(Exception $e)
        {
            $this->sendResponse(500, $e->getMessage());
        }
    }

    public function actionUpdate()
    {
        $model = AddressMap::requestToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        if(!$model->validate())
        {
            $this->sendResponse(500, $user->getErrors());
        }
        $record = DbAddress::findOne($model->id);
        if(empty($record))
        {
            $this->sendResponse(500, 'Invalid Address Id');
        }
        $record = AddressMap::updateDbModel($model, $record);
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
        $record = DbAddress::findOne($id);
        if(empty($record))
        {
           $this->sendResponse(500, 'Invalid Address Id'); 
        }
        try
        {
            $peopleAddresses = $record->getPeopleAddresses()->all();
            if(!empty($peopleAddresses))
            {
                $record->active = 0;
                $record->save();
                $this->sendResponse(200, '');
            }else
            {
                $record->delete();
                $this->sendResponse(200, '');
            }
        }catch(Exception $e)
        {
            $this->sendResponse(500, $e->getMessage());
        }
    }

    public function actionList()
    {
        $model = AddressMap::filterToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        $records = DbAddress::filter($model);
        if(empty($records))
        {
           $this->sendResponse(200, ''); 
        }
        $response = AddressMap::dbToResponse($records);
        // Mapeamento do que for para o Angular
        $this->sendResponse(200, $response); 
    }

}
