<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $articleLists=Article::find()->all();

        return $this->render('index',['articleLists'=>$articleLists]);
    }

    public function actionAdd(){
        $model=new Article();
        $article_category=ArticleCategory::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            }
        }

        return $this->render('add',['model'=>$model,'article_category'=>$article_category]);
    }

    public function actionEdit($id){
        $model=Article::findOne($id);
        $article_category=ArticleCategory::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            }
        }

        return $this->render('add',['model'=>$model,'article_category'=>$article_category]);

    }

    public function actionDelete($id){
        $model=Article::findOne($id);
        $model->status=-1;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['article/index']);
    }

}
