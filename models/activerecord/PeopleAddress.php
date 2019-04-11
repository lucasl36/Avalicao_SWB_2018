<?php

namespace app\models\activerecord;

use Yii;

/**
 * This is the model class for table "tb_people_address".
 *
 * @property int $people_id
 * @property int $address_id
 *
 * @property Address $address
 * @property People $people
 */
class PeopleAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_people_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['people_id', 'address_id'], 'required'],
            [['people_id', 'address_id'], 'integer'],
            [['people_id', 'address_id'], 'unique', 'targetAttribute' => ['people_id', 'address_id']],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['people_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['people_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasOne(People::className(), ['id' => 'people_id']);
    }
}
