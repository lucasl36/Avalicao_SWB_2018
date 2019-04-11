<?php

namespace app\models\activerecord;

use Yii;

/**
 * This is the model class for table "tb_user".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $name
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'login', 'password', 'name'], 'required'],
            [['id'], 'integer'],
            [['login', 'password'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 125],
            [['id'], 'unique'],
        ];
    }

}
