<?php

namespace app\controllers;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use app\components\ApiController;
use app\models\form\User as FormUser;
use app\models\db\User as DbUser;
use app\models\map\User as UserMap;

class UserController extends ApiController
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
                    'validate' => ['post'],
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
        $model = UserMap::requestToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        if(!$model->validate())
        {
            $this->sendResponse(500, $user->getErrors());
        }
        $record = UserMap::formToDb($model);
        $record->password = Yii::$app->getSecurity()->generatePasswordHash($record->password);
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
        $model = UserMap::requestToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        if(!$model->validate())
        {
            $this->sendResponse(500, $user->getErrors());
        }
        $record = DbUser::findOne($model->id);
        if(empty($record))
        {
            $this->sendResponse(500, 'Invalid User Id');
        }
        $record = UserMap::updateDbModel($model, $record);
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
        $record = DbUser::findOne($id);
        if(empty($record))
        {
           $this->sendResponse(500, 'Invalid User Id'); 
        }
        try
        {
            $record->delete();
            $this->sendResponse(200, '');
        }catch(Exception $e)
        {
            $this->sendResponse(500, $e->getMessage());
        }
    }

    public function actionList()
    {
        $model = UserMap::filterToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        $records = DbUser::filter($model);
        if(empty($records))
        {
           $this->sendResponse(200, ''); 
        }
        $response = UserMap::dbToResponse($records);
        // Mapeamento do que for para o Angular
        $this->sendResponse(200, $response); 
    }

    public function actionValidate()
    {
        $model = UserMap::requestLoginToForm(Yii::$app->request->post());
        // Mapeamento do que vir do Angular
        $user = DbUser::findByLogin($model->login);
        if(empty($user))
        {
            $this->sendResponse(500, 'User not found');   
        }
        if(!Yii::$app->getSecurity()->validatePassword($model->password, $user->password))
        {
            $this->sendResponse(500, 'Incorrect password');   
        }
        $response = UserMap::dbToLoginResponse($user);
        $this->sendResponse(200, $response);   
    }


}
