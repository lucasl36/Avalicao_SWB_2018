<?php

namespace app\models\activerecord;

use Yii;

/**
 * This is the model class for table "tb_address".
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property string $street_name
 * @property int $number
 * @property string $description
 * @property string $complement
 * @property int $id_type_adress
 *
 * @property TbTypeAddress $typeAdress
 * @property TbPeopleAddress[] $tbPeopleAddresses
 * @property TbPeople[] $peoples
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'street_name', 'number', 'description', 'id_type_adress'], 'required'],
            [['id', 'number', 'id_type_adress'], 'integer'],
            [['active'], 'boolean'],
            [['name'], 'string', 'max' => 125],
            [['street_name'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500],
            [['complement'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['id_type_adress'], 'exist', 'skipOnError' => true, 'targetClass' => TypeAddress::className(), 'targetAttribute' => ['id_type_adress' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeAdress()
    {
        return $this->hasOne(TypeAddress::className(), ['id' => 'id_type_adress']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeopleAddresses()
    {
        return $this->hasMany(PeopleAddress::className(), ['address_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeoples()
    {
        return $this->hasMany(People::className(), ['id' => 'people_id'])->viaTable('tb_people_address', ['address_id' => 'id']);
    }
}
