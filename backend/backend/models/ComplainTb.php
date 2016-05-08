<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "complain_tb".
 *
 * @property integer $id_complain
 * @property integer $id_unit
 * @property integer $date_complain
 * @property string $complain
 * @property string $solution
 * @property string $staff
 * @property boolean $status
 *
 * @property Unit $idUnit
 */
class ComplainTb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complain_tb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_complain'], 'safe'],
            [['complain', 'solution', 'code_unit','status'], 'string'],
            [['user_id','created_at','created_by','updated_at','updated_by'], 'integer']
        ];
    }

    public function behaviors()
    {
        /*return [
            TimestampBehavior::className(),
        ];*/

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function(){ return date('U'); /*unix timestamp */},
            ],
            'autouserid' => [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by'],
                ],
            ],
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_complain' => 'Id Complain',
            'code_unit' => 'Code Unit',
            'date_complain' => 'Date Complain',
            'complain' => 'Complain',
            'solution' => 'Solution',
            'user_id' => 'User',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodeUnit()
    {
        return $this->hasOne(Unit::className(), ['code' => 'code_unit']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
