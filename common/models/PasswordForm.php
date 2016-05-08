<?php
    namespace common\models;
   
    use Yii;
    use yii\base\Model;
    use common\models\User;
   
    class PasswordForm extends Model
    {
        const STATUS_ACTIVE = 10;
        const STATUS_NONACTIVE = 20;
        const STATUS_DELETED = 30;

        public $currentPassword;
        public $newPassword;
        public $newPasswordConfirm;

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['newPassword', 'currentPassword', 'newPasswordConfirm'], 'required'],
                [['currentPassword'], 'validateCurrentPassword'],
                [['newPassword', 'newPasswordConfirm'], 'string', 'min' => 3],
                [['newPassword', 'newPasswordConfirm'], 'filter', 'filter' => 'trim'],
                [['newPasswordConfirm'], 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Password do not match'],
            ];
        }

        /**
         * Attribute labels
         */
        public function attributeLabels()
        {
            return [
                'currentPassword' => 'Current Password',
                'newPassword' => 'New Password',
                'newPasswordConfirm' => 'Password Confirm',
            ];
        }

        public function validateCurrentPassword()
        {
            if(!$this->verifyPassword($this->currentPassword)) {
                $this->addError("currentPassword", "Current password incorrect");
            }
        }

        public function verifyPassword($password)
        {
            $dbpassword = User::findOne(['username' => Yii::$app->user->identity->username, 'status' => self::STATUS_ACTIVE])->password_hash;
            //var_dump($dbpassword); die();
            return Yii::$app->security->validatePassword($password, $dbpassword);
        }

    } 