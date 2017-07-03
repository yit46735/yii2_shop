<?php
namespace frontend\models;

use yii\base\Model;

class LoginForm extends Model{
    public $username;
    public $password;
    public $remember;
    public $code;

    public function rules()
    {
        return [
            [['username','password'],'required','message'=>'不能为空'],
            ['remember','boolean'],
//            ['code','captcha','captchaAction'=>'user/captcha',],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名：',
            'password'=>'密码：',
            'remember'=>'保存登录信息',
            'code'=>'验证码：',
        ];
    }

    public function login(){
        $member=Member::findOne(['username'=>$this->username]);
        if($member){

            if(\Yii::$app->security->validatePassword($this->password,$member->password_hash)){

                $duration=$this->remember?7*24*3600:0;
                \Yii::$app->user->login($member,$duration);
                return true;
            }else{
                $this->addError('password','密码不正确');
            }

        }else{
            $this->addError('username','用户不存在');
        }
        return false;
    }


}