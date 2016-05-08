<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\web\UploadedFile;


/**
 * This is the model class for table "profile_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $fullname
 * @property string $birthdate
 * @property integer $gender_id
 * @property string $created_at
 * @property string $updated_at
 */
class ProfileUser extends \yii\db\ActiveRecord
{
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_user';
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
            [['user_id', 'gender_id'], 'integer'],
            [['fullname', 'gender_id'], 'required'],
            [['avatar', 'filename', 'image'], 'safe'],
            [['image'], 'file', 'extensions' => 'jpg, jpeg, gif, png'],
            [['birthdate', 'created_at', 'updated_at'], 'safe'],
            [['fullname'], 'string', 'min' => 6, 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'fullname' => 'Fullname',
            'birthdate' => 'Birthdate',
            'gender_id' => 'Gender',
            'image' => 'Picture',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeValidate()
    {
        if($this->birthdate != null) {
            $new_date_format = date('Y-m-d', strtotime($this->birthdate));
            $this->birthdate = $new_date_format;
        }

        return parent::beforeValidate();
    }

    /**
     * fetch stored image file name with complete path
     * @return string
     */
    public function getImageFile()
    {
        return isset($this->avatar) ? Yii::$app->params['uploadPath'] . 'profiles/' . $this->avatar : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl()
    {
        // return a default image placeholder if your source avatar is not found
        $avatar = isset($this->avatar) ? $this->avatar : 'default_user.png';
        return Yii::$app->params['uploadUrl'] . 'profiles/' . $avatar;
    }

    /**
     * Process upload of image
     *
     * @return mixed the uploaded image instance
     */
    public function uploadImage()
    {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use getInstance method)
        $image = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if(empty($image)) {
            return false;
        }

        // store the source file name
        $this->filename = $image->name;
        $ext = end((explode(".", $image->name)));

        // generate a unique file name
        $this->avatar = Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $image;
    }

    /**
     * Process deletion of image
     *
     * @return boolean the status of deletion
     */
    public function deleteImage()
    {
        $file = $this->getImageFile();

        // check if file exists on server
        if(empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if(!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->avatar = null;
        $this->filename = null;

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenderName()
    {
        return $this->gender->gender_name;
    }

    /**
     * get list of gender for dropdown
     */
    public static function getGenderList()
    {
        $droptions = Gender::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'gender_name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @get Username
     */
    public function getUsername()
    {
        return $this->user->username;
    }

    /**
     * get Email
     */
    public function getEmail()
    {
        return $this->user->email;
    }

    /**
     * @getUserId
     */
    public function getUserId()
    {
        return $this->user ? $this->user->id : 'none';
    }

    /**
     * @getUserLink
     */
    public function getUserLink()
    {
        $url = Url::to(['user/view', 'id' => $this->UserId]);
        $options = [];
        return Html::a($this->getUserName(), $url, $options);
    }

    /**
     * @getProfileLink
     */
    public function getProfileIdLink()
    {
        $url = Url::to(['profile/update', 'id' => $this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }
}
