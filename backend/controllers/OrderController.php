<?php

namespace backend\controllers;

use frontend\models\Order;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=Order::find()->all();

        return $this->render('index',['models'=>$models]);
    }

    public function actionDeliver($id){
        $model=Order::findOne($id);
        $model->status=3;
        $model->save();
        \Yii::$app->session->setFlash('success','发货成功');
        return $this->redirect(['order/index']);
    }

    public function actionFinish($id){
        $model=Order::findOne($id);
        $model->status=4;
        $model->save();
        \Yii::$app->session->setFlash('success','订单已完成');
        return $this->redirect(['order/index']);
    }

}
