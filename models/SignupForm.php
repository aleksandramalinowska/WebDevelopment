<?php


namespace app\models;


use yii\helpers\VarDumper;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $first_name;
    public $last_name;
    public $email_address;

    public function rules()
    {
        return [
            // username, email and password are both required
            ['username', 'required', 'message' => "You must choose a username!"],
            ['email_address', 'required', 'message' => "You must enter you e-mail address!"],
            ['password', 'required', 'message' => "You must choose a password!"],
            ['password_repeat', 'required', 'message' => "You must fill in the password twice!"],
            // password must be longer than 8 characters and shorter than 64
            ['password', 'string', 'min' => 8, 'max' => 64, 'message' => "Password must be between 8 and 64 characters long"],
            // check if the passwords match
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match :("],
            //first and last name optional
            [['first_name', 'last_name'], 'string', 'min' => 2, 'max' => 45],
        ];
    }

    public function signup()
    {
        $user = new User;
        $user->username = $this->username;
        $user->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email_address = $this->email_address;
        $user->is_admin = 0;
        $user->access_token = \Yii::$app->getSecurity()->generateRandomString(64);
        $user->authentication_key = \Yii::$app->getSecurity()->generateRandomString(64);

        if ($user->save()) return true;
        else {
            \Yii::error("The user was not saved. " . VarDumper::dumpAsString($user->errors));
            return false;
        }
    }
}