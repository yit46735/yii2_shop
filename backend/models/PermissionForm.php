<?php
namespace backend\models;

use yii\base\Model;
use yii\rbac\Permission;

class PermissionForm extends Model{
    public $name;
    public $description;

    public function rules(){
        return [
            [['name','description'],'required']
        ];
    }

    public function attributeLabels(){
        return [
            'name'=>'权限名称',
            'description'=>'描述',
        ];
    }

    public function addPermission(){
        $authManager=\Yii::$app->authManager;
        if($authManager->getPermission($this->name)){
            $this->addError('name','权限已存在');
        }else{
            $permission=$authManager->createPermission($this->name);
            $permission->description=$this->description;

            return $authManager->add($permission);
        }
        return false;
    }

    public function loadData(Permission $permission){
        $this->name=$permission->name;
        $this->description=$permission->description;
    }

    public function updatePermission($name){
        $authManager=\Yii::$app->authManager;
        $permission=$authManager->getPermission($name);

        if($name!=$this->name && $authManager->getPermission($this->name)){
            $this->addError('name','权限已存在');

        }else{

            $permission->name=$this->name;
            $permission->description=$this->description;

            return $authManager->update($name,$permission);
        }
        return false;

    }


}