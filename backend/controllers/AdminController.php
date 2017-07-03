<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Admin;
use backend\models\ChangeForm;
use backend\models\LoginForm;
use backend\models\UserForm;
use yii\web\Request;
use yii\web\UploadedFile;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Admin::find()->all();
        return $this->render('index',['models'=>$models]);
    }

    public function actionAdd(){
        $model=new Admin(['scenario'=>Admin::SCENARIO_ADD]);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile = UploadedFile::getInstance($model, 'imgFile');
            if ($model->validate()) {
                if($model->imgFile){

                    $filename = '/images/photo' . uniqid() . '.' . $model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                    $model->photo = $filename;
                }
                $model->save(false);
                $id=$model->id;
                if($model->userToRole($id)){
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['admin/index']);
                }

            } else {
                var_dump($model->getErrors());
                exit;
            }
        }

        return $this->render('add', ['model' => $model]);
    }

    public function actionEdit($id){
        $model=Admin::findOne($id);
        $model->loadData($id);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile = UploadedFile::getInstance($model, 'imgFile');
            if ($model->validate()) {
                if($model->imgFile){

                    $filename = '/images/photo' . uniqid() . '.' . $model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                    $model->photo = $filename;
                }
                $model->save(false);
                if($model->userToRole($id)){
                    \Yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect(['admin/index']);
                }

            } else {
                var_dump($model->getErrors());
                exit;
            }
        }

        return $this->render('add', ['model' => $model]);
    }

    public function actionDelete($id){
        $model=Admin::findOne($id);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['admin/index']);
    }

    public function actionChange($id){
        $model=new ChangeForm();
        if($model->load(\yii::$app->request->post()) && $model->validate()){
            if($model->check_pwd($id)){
                $admin=Admin::findOne($id);
                $admin->password_hash=\Yii::$app->security->generatePasswordHash($model->password);
                $admin->save();
                \Yii::$app->session->setFlash('success','修改密码成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('change',['model'=>$model]);
    }

    public function actionLogin(){
        $model = new LoginForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->login()){
                $admin=Admin::findOne(['username'=>$model->username]);
                $admin->login_ip=\Yii::$app->request->userIP;
                $admin->login_time=time();
                $admin->status=0;
                $admin->save();
                \Yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    public function actionLogout()
    {
        $admin=Admin::findOne(['username'=>\Yii::$app->user->identity->username]);
        $admin->status=1;
        $admin->save();
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','成功');
        return $this->redirect(['admin/index']);
    }

    public function behaviors(){
        return [
            'RbacFilter'=>[
                'class'=>RbacFilter::className(),
                'only'=>['add','index'],
            ],
        ];
    }



}
