<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
//use backend\models\CoaType;

/**
 * This is the model class for table "coa".
 *
 * @property integer $id
 * @property string $code
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $name
 * @property string $debet_credit
 * @property integer $type
 *
 * @property Coa $parent
 * @property Coa[] $coas
 */
class Coa extends \yii\db\ActiveRecord
{
    const TYPE_DEBIT = 'D';
    const TYPE_CREDIT = 'C';

    public $bulkcoa;
    public $credit;
    public $debit;

    //public $fileupload;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coa';
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
            //[['code', 'name', 'debet_credit'], 'required'],
            [['name', 'debet_credit', 'type'], 'required'],
            [['parent_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'type', 'bank'], 'integer'],
            [['code'], 'string', 'max' => 64],
            [['name','bank_acc_number','bank_acc_name'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['bulkcoa','debit','credit'], 'string'],
            [['debet_credit'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'parent_id' => 'Parent ID',
            'parentCode' => 'Parent Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'name' => 'Name',
            'debet_credit' => 'Debet Credit',
            'type' => 'Type',
            'bank' => 'Bank',
            'bank_acc_number' => 'Bank Account Number',
            'bank_acc_name' => 'Bank Account Name',
            'debit' => 'Debit',
            'credit' => 'Credit',
            //'fileupload' => 'File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        //return $this->hasOne(Coa::className(), ['id' => 'parent_id']);
        return $this->hasOne(self::className(), 
            ['id' => 'parent_id'])->from(self::tableName() . ' AS parent');
    }

    /**
     * get for full coa name
     */
    /*public function getCode()
    {
        return $this->code;
    }*/

    /**
     * get for full parent name
     */
    public function getParentCode()
    {
        //return $this->parent['code'];
        $model = $this->parent;
        return $model ? $model->code:'';
    }

    public static function getParentList()
    {
        $droptions = Coa::find()->where(['parent_id' => null])->orderBy(['code'=>'asc'])->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoas()
    {
        return $this->hasMany(Coa::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoatype()
    {
        return $this->hasOne(CoaType::className(), ['id' => 'type']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoatypeName()
    {
        return $this->coatype->name;
    }

    public function getCoatypeCode()
    {
        return $this->coatype->type;
    }

    public function getCoatypeId()
    {
        return $this->coatype->id;
    }

    /**
     * get type of account
     */
    public function getCoatypeList()
    {
        $droptions = CoaType::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'name');
    }

    /**
     * get debet_credit
     */
    public function getDk()
    {
        return array(self::TYPE_DEBIT => 'DEBIT', self::TYPE_CREDIT => 'CREDIT' );
    }

    /**
     * get debet_credit label
     */
    public function getDkLabel($dk)
    {
        if($dk == self::TYPE_DEBIT) return "DEBIT";
        if($dk == self::TYPE_CREDIT) return "CREDIT";
    }

}
