<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class Admin extends ActiveRecord implements IdentityInterface{

    public $password;//保存密码的明文
    public $imgFile;
    public static $status=[1=>'男',0=>'女'];
    public $roles=[];

    const SCENARIO_ADD = 'add';

    public static function tableName()
    {
        return 'admin';
    }

    public function rules(){
        return [
            [['username','gender'],'required'],
            ['password','string','skipOnEmpty'=>false,'length'=>[6,12],'tooShort'=>'密码至少6位','on'=>self::SCENARIO_ADD],
            [['username'], 'unique'],
            ['imgFile','file','extensions'=>['jpg','gif','png']],
            ['imgFile','file','skipOnEmpty'=>false,'on'=>self::SCENARIO_ADD],
            ['roles','safe'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password' => '密码',
            'status' => '状态',
            'gender'=>'性别',
            'imgFile'=>'头像',
            'roles'=>'角色',
        ];
    }

    public static function getRoleOptions(){
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(),'name','description');
    }

    public function userToRole($id){
        $authManager = \Yii::$app->authManager;
        \Yii::$app->authManager->revokeAll($id);
        if($this->roles!=null){

            foreach($this->roles as $roleName){
                $role=$authManager->getRole($roleName);
                $authManager->assign($role,$id);
            }
        }
        return true;
    }

    public function loadData($id){
        foreach(\Yii::$app->authManager->getRolesByUser($id) as $role){
            $this->roles[]=$role->name;
        }
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->register_time = time();
            $this->status = 1;
            //生成随机字符串
            $this->auth_key = \Yii::$app->security->generateRandomString();
        }
        if($this->password){
            $this->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey;
    }
}