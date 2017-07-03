<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Admin;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use backend\models\UserForm;
use yii\web\NotFoundHttpException;

class RbacController extends \yii\web\Controller
{

    //权限
    public function actionPermissionIndex()
    {
        $models=\Yii::$app->authManager->getPermissions();

        return $this->render('Permission-index',['models'=>$models]);
    }

    public function actionAddPermission(){
        $model=new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addPermission()){
                \Yii::$app->session->setFlash('success','添加权限成功');
                return $this->redirect(['rbac/permission-index']);
            }
        }

        return $this->render('add-permission',['model'=>$model]);
    }

    public function actionEditPermission($name){
        $permission=\Yii::$app->authManager->getPermission($name);
        if($permission==null){
            throw new NotFoundHttpException('权限不存在');
        }

        $model=new PermissionForm();

        $model->loadData($permission);

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->updatePermission($name)){
                \Yii::$app->session->setFlash('success','修改权限成功');
                return $this->redirect(['rbac/permission-index']);
            }
        }

        return $this->render('add-permission',['model'=>$model]);
    }

    public function actionDeletePermission($name){
        $permission=\Yii::$app->authManager->getPermission($name);
        if($permission==null){
            throw new NotFoundHttpException('权限不存在');
        }
        \Yii::$app->authManager->remove($permission);
        \Yii::$app->session->setFlash('success','删除权限成功');
        return $this->redirect(['rbac/permission-index']);
    }


    //角色
    public function actionRoleIndex(){
        $models=\Yii::$app->authManager->getRoles();

        return $this->render('role-index',['models'=>$models]);
    }

    public function actionAddRole(){
        $model=new RoleForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addRole()){
                \Yii::$app->session->setFlash('success','添加角色成功');
                return $this->redirect(['rbac/role-index']);
            }
        }

        return $this->render('add-role',['model'=>$model]);

    }

    public function actionEditRole($name){
        $role=\Yii::$app->authManager->getRole($name);
        if($role==null){
            throw new NotFoundHttpException('角色不存在');
        }
        $model=new RoleForm();
        $model->loadDate($role);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->updateRole($name)){
                \Yii::$app->session->setFlash('success','修改角色成功');
                return $this->redirect(['rbac/role-index']);
            }
        }

        return $this->render('add-role',['model'=>$model]);
    }

    public function actionDeleteRole($name){
        $role=\Yii::$app->authManager->getRole($name);
        if($role==null){
            throw new NotFoundHttpException('角色不存在');
        }
        \Yii::$app->authManager->remove($role);
        \Yii::$app->session->setFlash('success','删除角色成功');
        return $this->redirect(['rbac/role-index']);
    }

    public function behaviors(){
        return [
            'RbacFilter'=>[
                'class'=>RbacFilter::className(),
            ],
        ];
    }

//    public function actionUser($id){
//        $user=Admin::findOne($id);
//        if($user==null){
//            throw new NotFoundHttpException('用户不存在');
//        }
//        $model=new UserForm();
//
//        if(\Yii::$app->authManager->getRolesByUser($id)){
//            $model->loadData($id);
//            if($model->load(\Yii::$app->request->post()) && $model->validate()){
//
//                if($model->userToRole($id)){
//                    \Yii::$app->session->setFlash('success','授予角色成功');
//                    return $this->redirect(['admin/index']);
//                }
//            }
//        }else{
//            if($model->load(\Yii::$app->request->post()) && $model->validate()){
//                if($model->userToRole($id)){
//                    \Yii::$app->session->setFlash('success','授予角色成功');
//                    return $this->redirect(['admin/index']);
//                }
//            }
//        }
//
//
//        return $this->render('user-role',['model'=>$model]);
//
//    }

}
