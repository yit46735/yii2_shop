<?php
namespace backend\models;

use yii\base\Model;

class ChangeForm extends Model{
    public $oldpassword;
    public $password;
    public $confirm_pwd;

    public function rules(){
        return [
            [['oldpassword','password','confirm_pwd'],'required'],
            ['confirm_pwd','compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
            [['password','confirm_pwd'],'string','length'=>[6,12]],
        ];
    }

    public function attributeLabels(){
        return [
            'oldpassword'=>'旧密码',
            'password'=>'新密码',
            'confirm_pwd'=>'确认密码',

        ];

    }

    public function check_pwd($id){
        $user=Admin::findOne($id);
        if($user){
            if(!\Yii::$app->security->validatePassword($this->oldpassword,$user->password_hash)){

                $this->addError('oldpassword','原密码不正确');
            }else{
                return true;
            }
        }else{
            $this->addError('oldpassword','原密码不正确');
        }
    }


}