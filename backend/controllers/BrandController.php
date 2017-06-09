<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $brandLists=Brand::find()->all();

        return $this->render('index',['brandLists'=>$brandLists]);
    }

    public function actionAdd(){
        $model=new Brand();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo=$fileName;
                }

                $model->save(false);
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id){
        $model=Brand::findOne($id);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    $fileName='/images/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo=$fileName;
                }

                $model->save(false);
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['brand/index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($id){
        $model=Brand::findOne($id);
        $model->status=-1;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['brand/index']);
    }

}