<?php

namespace app\models\form;

use Yii;

class User extends \yii\base\Model
{
    public $id;
    public $login;
    public $password;
    public $name;

    public function rules()
    {
        return [
            [['login', 'password', 'name'], 'required'],
            [['id'], 'integer'],
            [['login', 'password'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 125],
        ];
    }

}
