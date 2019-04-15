<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "tb_people".
 *
 * @property int $id
 * @property string $name
 * @property string $cpfcnpj
 * @property string $rgie
 * @property string $people_type
 * @property string $mail_address
 * @property string $phone
 * @property string $cell_phone
 * @property string $birth
 * @property int $employess_amount
 *
 * @property PeopleAddress[] $peopleAddresses
 * @property Address[] $addresses
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
            [['name', 'cpfcnpj', 'rgie', 'people_type', 'mail_address', 'phone', 'cell_phone'], 'required'],
            [['id', 'employess_amount'], 'integer'],
            [['birth'], 'safe'],
            [['name'], 'string', 'max' => 125],
            [['cpfcnpj'], 'string', 'max' => 15],
            [['rgie'], 'string', 'max' => 50],
            [['people_type'], 'string', 'max' => 1],
            [['mail_address'], 'string', 'max' => 100],
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

    public static function filter($formModel)
    {
        return self::find()
        ->andFilterCompare('name', $formModel->name, 'like')
        ->andFilterCompare('cpfcnpj', $formModel->cpfcnpj, 'like')
        ->andFilterCompare('rgie', $formModel->rgie, 'like')
        ->andFilterCompare('people_type', $formModel->people_type)
        ->andFilterCompare('mail_address', $formModel->mail_address, 'like')
        ->andFilterCompare('phone', $formModel->phone, 'like')
        ->andFilterCompare('cell_phone', $formModel->cell_phone, 'like')
        ->andFilterCompare('birth', $formModel->birth)
        ->andFilterCompare('birth', $formModel->employess_amount)
        ->all();
    }


}
