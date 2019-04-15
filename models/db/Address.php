<?php

namespace app\models\db;

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
 * @property int $id_type_address
 *
 * @property TypeAddress $typeaddress
 * @property PeopleAddress[] $peopleAddresses
 * @property People[] $peoples
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
            [['name', 'street_name', 'number', 'description', 'id_type_address'], 'required'],
            [['id', 'number', 'id_type_address'], 'integer'],
            [['active'], 'boolean'],
            [['name'], 'string', 'max' => 125],
            [['street_name'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500],
            [['complement'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['id_type_address'], 'exist', 'skipOnError' => true, 'targetClass' => TypeAddress::className(), 'targetAttribute' => ['id_type_address' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeAddress()
    {
        return $this->hasOne(TypeAddress::className(), ['id' => 'id_type_address']);
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

    public static function filter($formModel)
    {
        return self::find()
        ->innerJoin('tb_people_address pa', 'tb_address.id = pa.address_id')
        ->innerJoin('tb_people p', 'pa.people_id = p.id')
        ->andFilterCompare('tb_address.name', $formModel->name, 'like')
        ->andFilterCompare('active', $formModel->active)
        ->andFilterCompare('street_name', $formModel->street_name, 'like')
        ->andFilterCompare('number', $formModel->number)
        ->andFilterCompare('description', $formModel->description, 'like')
        ->andFilterCompare('complement', $formModel->complement, 'like')
        ->andFilterCompare('id_type_address', $formModel->id_type_address)
        ->andFilterCompare('p.name', $formModel->name_people, 'like')
        ->all();
    }

}
