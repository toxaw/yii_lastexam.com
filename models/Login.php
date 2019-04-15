<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fio
 * @property string $login
 * @property string $email
 * @property string $password
 * @property int $is_admin
 */
class Login extends \yii\base\Model
{
    public $login;

    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required', 'message' => 'Заполните поле {attribute}'],
            [['login','password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function login()
    {
        if($this->validate())
        {
            return User::findOne(['login' => $this->login]);          
        }
    }
}
