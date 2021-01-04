<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property int $is_admin
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email_address
 * @property string $access_token
 * @property string $authentication_key
 *
 * @property Cart[] $carts
 * @property Comment[] $comments
 * @property Order[] $orders
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'is_admin', 'email_address', 'access_token', 'authentication_key'], 'required'],
            [['is_admin'], 'integer'],
            [['username', 'first_name', 'last_name', 'email_address'], 'string', 'max' => 45],
            [['password_hash'], 'string', 'max' => 60],
            [['access_token', 'authentication_key'], 'string', 'max' => 64],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'is_admin' => 'Is Admin',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email_address' => 'Email Address',
            'access_token' => 'Access Token',
            'authentication_key' => 'Authentication Key',
        ];
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    public static function findByUsername($name)
    {
        return self::findOne(['username' => $name]);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return $this->authentication_key;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authentication_key === $authKey;
    }

    public function validatePassword($value)
    {
        return \Yii::$app->getSecurity()->validatePassword($value, $this->password_hash);
    }

}
