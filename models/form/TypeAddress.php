<?php

namespace app\models\form;

use Yii;

class TypeAddress extends \yii\base\Model
{

    public $id;
    public $name;
    public $active;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id'], 'integer'],
            [['active'], 'boolean'],
            [['name'], 'string', 'max' => 125],
        ];
    }

}
