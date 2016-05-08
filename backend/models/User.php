<?php

namespace backend\models;

use Yii;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use yii\helpers\Security;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 10;
    const STATUS_NONACTIVE = 20;
    const STATUS_DELETED = 30;

    public $password;
    public $newPasswordConfirm;

    public $lastLogin;
    public $lastLogout;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
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
            ['status', 'default', 'value' => self::STATUS_NONACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_NONACTIVE]],
            [['username', 'password', 'status'], 'required'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique'],
            ['username', 'string', 'min' => 6, 'max' => 100],
            ['email', 'required'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique'],
            [['lastLogin', 'lastLogout'], 'integer'],
            [['password', 'newPasswordConfirm'], 'string', 'min' => 6, 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userid' => 'Userid',
            'username' => 'Username',
            'status' => 'Status',
            'password' => 'Password',
            'newPasswordConfirm' => 'Confirm Password',
        ];
    }

    public function lastLogin()
    {
        return date('U');
    }

    public function lastLogout()
    {
        return date('U');    
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authkey)
    {
        return $this->getAuthKey() === $authkey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @getProfile
     */
    public function getProfile()
    {
        return $this->hasOne(ProfileUser::className(), ['user_id' => 'id']);
    }

    /**
     * @getProfileId
     */
    public function getProfileId()
    {
        return $this->profile ? $this->profile->id : 'none';
    }

    /**
     * get Profile Fullname
     */
    public function getFullname()
    {
        $profile = $this->profile;
        //return $profile ? $profile->fullname: '<span class="not-set">(Create Profile)</span>';
        return $profile ? $profile->fullname: null;
    }

    /**
     * @getProfileLink
     */
    public function getProfileLink()
    {
        $url = Url::to(['profile/view', 'id' => $this->profileId]);
        $options = [];
        return Html::a($this->profile ? 'profile' : 'none', $url, $options);
    }

    /**
     * get user id Link
     */
    public function getUserIdLink()
    {
        $url = Url::to(['user/update', 'id' => $this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }

    /**
     * @getUserLink
     */
    public function getUserLink()
    {
        $url = Url::to(['user/view', 'id' => $this->id]);
        $options = [];
        return Html::a($this->username, $url, $options);
    }

    /**
     * get Status
     */
    public function getStatus()
    {
        return array(self::STATUS_ACTIVE => 'ACTIVE', self::STATUS_NONACTIVE => 'NON ACTIVE', self::STATUS_DELETED => 'DELETED');
    }

    /**
     * get Status Label
     */
    public function getStatusLabel($status)
    {
        if($status == self::STATUS_ACTIVE) return '<p class="text-center"><span class="label label-primary"><i class="glyphicon glyphicon-ok"></i></span></p>';
        if($status == self::STATUS_NONACTIVE) return '<p class="text-center"><span class="label label-warning"><i class="glyphicon glyphicon-ban-circle"></i></span></p>';
        if($status == self::STATUS_DELETED) return '<p class="text-center"><span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span></p>';
    }

    /**
     * get Avatar
     */
    public function getAvatar()
    {
        $profile = $this->profile;
        return $profile ? $profile->imageUrl : null;
    }
}
