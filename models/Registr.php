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
 * @property string $auth_key
 * @property int $is_admin
 */
class Registr extends \yii\base\Model
{
    
    public $fio;

    public $password;

    public $repeatPassword;

    public $email;

    public $login;

    public $agree;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
 return [
            [['fio', 'password', 'email', 'repeatPassword','agree','login'], 'required', 'message' => 'Заполните поле {attribute}'],
            [['fio', 'password', 'email', 'repeatPassword','login'],'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            ['login', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой логин уже существует'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой email уже существует'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password'],
            ['login', 'match','pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Логин может содержать только латинские символы и цифры, без пробелов'],
            ['fio', 'match','pattern' => '/^[а-яА-Я]+\s[а-яА-Я]+\s[а-яА-Я]+$/ui', 'message'=>'ФИО могут содержать только кирилицу и должны быть разделены пробелами'],
            ['agree', 'compare', 'compareValue' => 1, 'message' => 'Необходимо согласие на обработку данных!'], 
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
       return [
            'fio' => 'ФИО',
            'password' => 'Пароль',
            'repeatPassword' => 'Повторите пароль',
            'email' => 'Email',
            'login' => 'Логин',
            'agree' => 'Согласен на обработку персональных данных'
        ];
    }

    public function registr()
    {
        if ($this->validate())
        {
            $user = new User();

            $user->fio = $this->fio;

            $user->login = $this->login;

            $user->email = $this->email;

            $user->password = $this->password;
            
            $user->save(); 
            
            return $user;
        }
    }
}
