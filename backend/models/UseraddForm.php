<?php
namespace backend\models;

use backend\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class UseraddForm extends Model
{
    const STATUS_ACTIVE = 10;
    const STATUS_NONACTIVE = 20;
    const STATUS_DELETED = 30;

    public $username;
    public $email;
    public $password;
    public $newPasswordConfirm;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 6, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            [['password', 'status'], 'required'],
            [['password', 'newPasswordConfirm'], 'string', 'min' => 6],
            [['password', 'newPasswordConfirm'], 'filter', 'filter' => 'trim'],
            [['newPasswordConfirm'], 'compare', 'compareAttribute' => 'password', 'message' => 'Password do not match'],
            [['status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'status' => 'Status',
            'password' => 'Password',
            'newPasswordConfirm' => 'Confirm Password'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function addnew()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $this->status;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            
            if ($user->save(false)) {
                return $user;
            }
            /*$user->save(false);
            $auth = Yii::$app->authManager;
            $authRole = $auth->getRole('author');
            $auth->assign($authRole, $user->getId());

            return $user;*/
        }

        return null;
    }

    static function getIsNewRecord()
    {
        return true;
    }
}
