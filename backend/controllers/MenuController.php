<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Menu;

class MenuController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Menu::find()->orderBy('label DESC,sort ASC')->all();

        return $this->render('index',['models'=>$models]);
    }

    public function actionAdd(){

        $model=new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','添加菜单成功');
            return $this->redirect(['menu/index']);
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id){
        $model=Menu::findOne($id);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','修改菜单成功');
            return $this->redirect(['menu/index']);
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($id){
        $model=Menu::findOne($id);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除菜单成功');
        return $this->redirect(['menu/index']);
    }

    public function behaviors(){
        return [
            'RbacFilter'=>[
                'class'=>RbacFilter::className(),
            ],
        ];
    }

}
