<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use app\components\ApiController;
use app\models\form\People as FormPeople;
use app\models\db\People as DbPeople;
use app\models\map\People as PeopleMap;

class PeopleController extends ApiController
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
        $model = PeopleMap::requestToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        if(!$model->validate())
        {
            $this->sendResponse(500, $user->getErrors());
        }
        $record = PeopleMap::formToDb($model);
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
        $model = PeopleMap::requestToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        if(!$model->validate())
        {
            $this->sendResponse(500, $user->getErrors());
        }
        $record = DbPeople::findOne($model->id);
        if(empty($record))
        {
            $this->sendResponse(500, 'Invalid Person Id');
        }
        $record = PeopleMap::updateDbModel($model, $record);
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
        $record = DbPeople::findOne($id);
        if(empty($record))
        {
           $this->sendResponse(500, 'Invalid Person Id'); 
        }
        try
        {
            $addresses = $record->getPeopleAddresses()->all();
            if(!empty($addresses))
            {
                $this->sendResponse(500, 'Cant delete a person with registered addresses'); 
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
        $model = PeopleMap::filterToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        $records = DbPeople::filter($model);
        if(empty($records))
        {
           $this->sendResponse(200, ''); 
        }
        $response = PeopleMap::dbToResponse($records);
        // Mapeamento do que for para o Angular
        $this->sendResponse(200, $response); 
    }

}
