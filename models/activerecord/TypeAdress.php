<?php

namespace app\models\activerecord;

use Yii;

/**
 * This is the model class for table "tb_type_address".
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 *
 * @property Address[] $tbAddresses
 */
class TypeAdress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_type_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['active'], 'boolean'],
            [['name'], 'string', 'max' => 125],
            [['id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['id_type_adress' => 'id']);
    }
}
