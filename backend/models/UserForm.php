<?php
namespace backend\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserForm extends Model{
//    public $name;
    public $roles=[];

    public function rules(){
        return [
            ['roles','safe'],
        ];
    }

    public function attributeLabels(){
        return [
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
}