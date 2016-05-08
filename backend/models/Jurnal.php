<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\JurnalChild;

/**
 * This is the model class for table "jurnal".
 *
 * @property integer $id
 * @property string $debit
 * @property string $credit
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $date
 * @property string $status
 * @property string $ref
 * @property string $code
 *
 * @property JurnalChild[] $jurnalChildren
 */
class Jurnal extends \yii\db\ActiveRecord
{    
    const STATUS_POSTED = 10;
    const STATUS_DRAFT = 20;
    const STATUS_VOID = 30;

    public $from_date;
    public $to_date;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jurnal';
    }

    /**
     * @inheritdoc
     */
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
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debit', 'credit'], 'number'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'no'], 'integer'],
            [['date', 'from_date', 'to_date'], 'safe'],
            [['ref', 'code'], 'string', 'max' => 25],
            [['description'], 'string', 'max' => 255],
            [['no'], 'unique'],
            [['description','date', 'status'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'debit' => 'Debit',
            'credit' => 'Credit',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'date' => 'Date',
            'status' => 'Status',
            'description' => 'Description',
            'ref' => 'Ref',
            'code' => 'Code',
            'no' => 'No',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurnalChildren()
    {
        return $this->hasMany(JurnalChild::className(), ['id_jur' => 'id']);
    }

    public function getStatus()
    {
        return array(self::STATUS_DRAFT =>'DRAFT', self::STATUS_POSTED => 'POSTED', self::STATUS_VOID => 'VOID');
    }

    public function getStatusLabel($status)
    {    
        if($status == self::STATUS_POSTED) return 'POSTED';
        if($status == self::STATUS_DRAFT) return 'DRAFT';
        if($status == self::STATUS_VOID) return 'VOID';
    }
}
