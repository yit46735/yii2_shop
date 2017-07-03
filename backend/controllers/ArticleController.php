<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $articleLists=Article::find()->all();

        return $this->render('index',['articleLists'=>$articleLists]);
    }

    public function actionAdd(){
        $article = new Article();
        $article_detail = new ArticleDetail();
        if($article->load(\Yii::$app->request->post())
            && $article_detail->load(\Yii::$app->request->post())
            && $article->validate()
            && $article_detail->validate()){
            $article->save();
            $article_detail->article_id = $article->id;
            $article_detail->save();

            \Yii::$app->session->setFlash('success','文章添加成功');
            return $this->redirect(['index']);
        }
        return $this->render('add',['article'=>$article,'article_detail'=>$article_detail]);
    }

    public function actionEdit($id){
        $article = Article::findOne(['id'=>$id]);
        $article_detail = $article->detail;
        if($article->load(\Yii::$app->request->post())
            && $article_detail->load(\Yii::$app->request->post())
            && $article->validate()
            && $article_detail->validate()){
            $article->save();
            $article_detail->save();


            \Yii::$app->session->setFlash('success','文章修改成功');
            return $this->redirect(['index']);
        }

        return $this->render('add',['article'=>$article,'article_detail'=>$article_detail]);

    }

    public function actionDelete($id){
        $model=Article::findOne($id);
        $model->status=-1;
        $model->save();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['article/index']);
    }

    public function actionView($id)
    {
        $model = Article::findOne($id);

        return $this->render('view',['model'=>$model]);
    }

    public function behaviors(){
        return [
            'RbacFilter'=>[
                'class'=>RbacFilter::className(),
                'only'=>['add','index','edit','delete','view'],
            ],
        ];
    }





    //百度编辑器
    public function actions()
    {
        return [

            'ueditor' => [
                'class' => 'crazyfd\ueditor\Upload',
                'config'=>[
                    'uploadDir'=>date('Y/m/d')
                ]

            ],
        ];
    }

}
