<?php
 
namespace app\models;
 
use yii\base\Model;
 
/**
 * Signup form
 */
class RegistrForm extends Model
{
 
    public $username;

    public $email;

    public $password;

    public $password_repeat;

    public $firstname;

    public $lastname;

    public $middlename;

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['fio','login','password','password_repeat','email'], 'string', 'required']

            [['username', 'firstname', 'lastname', 'middlename'], 'trim'],
            [['username', 'firstname', 'lastname'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой логин уже существует'],
            [['username', 'firstname', 'lastname', 'middlename'], 'string', 'min' => 2, 'max' => 255],
            [['username', 'firstname', 'lastname', 'middlename'],'filter','filter' => function ($value) 
                                                                                    {
                                                                                        return htmlspecialchars(strip_tags($value));
                                                                                    }
            ],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой адрес почты уже существует'],
            [['password','password_repeat'], 'required'],
            [['password','password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password','message' => 'Повторный пароль не совпадает с текущим'],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'email' => 'E-Mail',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function registr()
    { 
        if (!$this->validate()) 
        {
            return null;
        }
 
        $user = new User();

        $user->username = $this->username;

        $user->email = $this->email;

        $user->firstname = $this->firstname;

        $user->lastname = $this->lastname;

        $user->middlename = $this->middlename;

        $user->setPassword($this->password);

        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}