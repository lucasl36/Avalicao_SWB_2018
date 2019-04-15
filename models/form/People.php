<?php

namespace app\models\form;

use Yii;

class People extends \yii\base\Model
{

    public $id;
    public $name;
    public $cpfcnpj;
    public $rgie;
    public $people_type;
    public $mail_address;
    public $phone;
    public $cell_phone;
    public $birth;
    public $employess_amount;

    public function rules()
    {
        return [
            [['name', 'cpfcnpj', 'rgie', 'people_type', 'mail_address', 'phone', 'cell_phone'], 'required'],
            [['id', 'employess_amount'], 'integer'],
            [['name'], 'string', 'max' => 125],
            [['cpfcnpj'], 'string', 'max' => 15],
            [['rgie'], 'string', 'max' => 50],
            [['people_type'], 'string', 'max' => 1],
            [['mail_address'], 'string', 'max' => 100],
            [['phone', 'cell_phone'], 'string', 'max' => 20],
        ];
    }

}
