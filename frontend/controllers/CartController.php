<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Cart;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class CartController extends \yii\web\Controller
{
    public $layout='login';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd(){


        $goods_id=\Yii::$app->request->post('goods_id');
        $amount=\Yii::$app->request->post('amount');
        $goods=Goods::findOne(['id'=>$goods_id]);
        if($goods==null){
            throw new NotFoundHttpException('该商品不存在');
        }
        if(\Yii::$app->user->isGuest){

            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie==null){
                $cart=[];
            }else{
                $cart=unserialize($cookie->value);
            }


            $cookies=\Yii::$app->response->cookies;

            if(array_key_exists($goods->id,$cart)){
                $cart[$goods_id]+=$amount;
            }else{
                $cart[$goods_id]=$amount;
            }
            $cookie=new Cookie([
                'name'=>'cart','value'=>serialize($cart),'expire'=>time()+600,
            ]);
            $cookies->add($cookie);

        }else{


            $member_id=\Yii::$app->user->getId();
            $model=Cart::find()->where(['member_id'=>$member_id])->andWhere(['goods_id'=>$goods_id])->one();
            if($model){
                $model->amount+=$amount;
                $model->save();
            }else{
                $model=new Cart();


                $model->goods_id=$goods_id;
                $model->amount=$amount;
                $model->member_id=$member_id;
                $model->save();

            }


        }

        return $this->redirect(['cart/cart']);
    }

    public function actionCart(){
        $models=[];
        if(\Yii::$app->user->isGuest){

            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');

            if($cookie==null){
                $cart=[];
            }else{
                $cart=unserialize($cookie->value);
            }

            foreach($cart as $goods_id=>$amount){
                $goods=Goods::find()->where(['id'=>$goods_id])->asArray()->one();
                $goods['amount']=$amount;
                $models[]=$goods;
            }
        }else{

            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            $member_id=\Yii::$app->user->getId();
            if($cookie==null){
                $cart=[];
            }else{
                $cart=unserialize($cookie->value);
            }



                foreach($cart as $goods_id=>$amount){
                    $goods=Goods::find()->where(['id'=>$goods_id])->asArray()->one();
                    $goods['amount']=$amount;

                    $model=Cart::find()->where(['member_id'=>$member_id])->andWhere(['goods_id'=>$goods_id])->one();
                    if($model){
                        $model->amount+=$amount;
                        $model->save();
                    }else{
                        $model=new Cart();


                        $model->goods_id=$goods_id;
                        $model->amount=$amount;
                        $model->member_id=$member_id;
                        $model->save();

                    }


                }
            $cookies=\Yii::$app->response->cookies;
            $cookies->get('cart');
            $cookies->remove('cart');
            $models=[];
            $carts=Cart::find()->where(['member_id'=>$member_id])->asArray()->all();
            foreach($carts as $cart){
                $goods=Goods::find()->where(['id'=>$cart['goods_id']])->asArray()->one();
                $goods['amount']=$cart['amount'];
                $models[]=$goods;
            }





        }

        return $this->render('cart',['models'=>$models]);

    }

    public function actionUpdate(){
        $goods_id=\Yii::$app->request->post('goods_id');
        $amount=\Yii::$app->request->post('amount');
        $goods=Goods::findOne(['id'=>$goods_id]);
        if($goods==null){
            throw new NotFoundHttpException('该商品不存在');
        }
        if(\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie==null){
                $cart=[];
            }else{
                $cart=unserialize($cookie->value);
            }


            $cookies=\Yii::$app->response->cookies;

            if($amount){
                $cart[$goods_id]=$amount;
            }else{
                if(array_key_exists($goods->id,$cart)) unset($cart[$goods_id]);

            }
            $cookie=new Cookie([
                'name'=>'cart','value'=>serialize($cart)
            ]);
            $cookies->add($cookie);
        }else{
            $member_id=\Yii::$app->user->getId();
            $model=Cart::find()->where(['member_id'=>$member_id])->andWhere(['goods_id'=>$goods_id])->one();
            if($model){
                if($amount){

                    $model->amount=$amount;
                    $model->save();
                }else{
                    $model->delete();
                }
            }
        }
    }

    public function actionTest(){
        $cookies=\Yii::$app->request->cookies;
        $cookie=$cookies->get('cart');
        var_dump(unserialize($cookie->value));

    }

}
