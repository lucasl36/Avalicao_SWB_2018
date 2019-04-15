<?php

namespace app\models\form;

use Yii;

class Address extends \yii\base\Model
{

    const form_scenario = 'form';
    const filter_scenario = 'filter';

    public $id;
    public $name;
    public $active;
    public $street_name;
    public $number;
    public $description;
    public $complement;
    public $id_people;
    public $name_people;
    public $id_type_address;

    public function rules()
    {
        return [
            [['name', 'street_name', 'number', 'description', 'id_type_address'], 'required'],
            [['id_people'], 'required', 'on' => 'form'],
            [['name_people'], 'required', 'on' => 'filter'],
            [['id', 'number', 'id_people', 'id_type_address'], 'integer'],
            [['active'], 'boolean'],
            [['name'], 'string', 'max' => 125],
            [['street_name'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500],
            [['complement'], 'string', 'max' => 50],
        ];
    }

}
