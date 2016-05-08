<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "type_charge".
 *
 * @property integer $id
 * @property string $name_type
 * @property string $code_type
 */
class TypeCharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_charge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_type'], 'string', 'max' => 100],
            [['code_type'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_type' => 'Name Type',
            'code_type' => 'Code Type',
        ];
    }
}
