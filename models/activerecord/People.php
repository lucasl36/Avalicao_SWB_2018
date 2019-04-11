<?php

namespace app\models\activerecord;

use Yii;

/**
 * This is the model class for table "tb_people".
 *
 * @property int $id
 * @property string $name
 * @property string $cpfcnpj
 * @property string $rgie
 * @property string $people_type
 * @property string $mail_adress
 * @property string $phone
 * @property string $cell_phone
 * @property string $birth
 * @property int $employess_amount
 *
 * @property TbPeopleAddress[] $tbPeopleAddresses
 * @property TbAddress[] $addresses
 */
class People extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_people';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'cpfcnpj', 'rgie', 'people_type', 'mail_adress', 'phone', 'cell_phone'], 'required'],
            [['id', 'employess_amount'], 'integer'],
            [['birth'], 'safe'],
            [['name'], 'string', 'max' => 125],
            [['cpfcnpj'], 'string', 'max' => 15],
            [['rgie'], 'string', 'max' => 50],
            [['people_type'], 'string', 'max' => 1],
            [['mail_adress'], 'string', 'max' => 100],
            [['phone', 'cell_phone'], 'string', 'max' => 20],
            [['id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeopleAddresses()
    {
        return $this->hasMany(PeopleAddress::className(), ['people_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['id' => 'address_id'])->viaTable('tb_people_address', ['people_id' => 'id']);
    }
}
