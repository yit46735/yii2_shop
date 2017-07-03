<?php

namespace frontend\controllers;






use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\db\Exception;
use yii\helpers\Url;

class OrderController extends \yii\web\Controller
{
    public $layout='login';

    public function actionOrderIndex()
    {

        if(\Yii::$app->user->isGuest){
            return $this->redirect(Url::to(['user/login']));
        }
        $user_id=\Yii::$app->user->getId();
        $models=Address::find()->where(['user_id'=>$user_id])->all();
        $carts=Cart::find()->where(['member_id'=>$user_id])->all();



        return $this->render('index',['models'=>$models,'carts'=>$carts]);
    }

    public function actionAdd(){
        $total=\Yii::$app->request->post('total');
        $address_id=\Yii::$app->request->post('address_id');
        $delivery_id=\Yii::$app->request->post('delivery_id');
        $payment_id=\Yii::$app->request->post('payment_id');
        $member_id=\Yii::$app->user->getId();
        $model=new Order();
        $model->member_id=$member_id;
        $model->name=Address::findOne(['id'=>$address_id])->username;
        $model->province=Address::findOne(['id'=>$address_id])->provinceName->name;
        $model->city=Address::findOne(['id'=>$address_id])->cityName->name;
        $model->area=Address::findOne(['id'=>$address_id])->areaName->name;
        $model->address=Address::findOne(['id'=>$address_id])->address;
        $model->tel=Address::findOne(['id'=>$address_id])->tel;
        $model->delivery_id=$delivery_id;
        $model->delivery_name=Order::$deliveries[$delivery_id-1]['name'];
        $model->delivery_price=Order::$deliveries[$delivery_id-1]['price'];
        $model->payment_id=$payment_id;
        $model->payment_name=Order::$payments[$payment_id-1]['name'];
        $model->total=$total;
        $model->status=2;
        $model->create_time=time();
        $model->trade_no=date('ymd').uniqid();

        //开启事务
        $transation=\Yii::$app->db->beginTransaction();
        try{
            $model->save();

                $carts=Cart::find(['member_id'=>$member_id])->all();
                if($carts){
                    foreach($carts as $cart){
                        $goods=\backend\models\Goods::findOne(['id'=>$cart->goods_id]);
                        if($goods==null){
                            throw new Exception($goods->name.'已售完');
                        }
                        if($goods->stock < $cart->amount){
                            throw new Exception($goods->name.'库存不足');
                        }
                        $order_goods=new OrderGoods();
                        $order_goods->order_id=$model->id;
                        $order_goods->goods_id=$cart->goods_id;
                        $order_goods->goods_name=$goods->name;
                        $order_goods->logo=$goods->logo;
                        $order_goods->price=$goods->shop_price;
                        $order_goods->amount=$cart->amount;
                        $order_goods->total=$total;
                        $order_goods->save();

                        //购买成功减去库存
                        $goods->stock-=$cart->amount;
                        $goods->save();
                    }
                }
                Cart::deleteAll(['member_id'=>$member_id]);
            $transation->commit();
                echo 'success';

        }catch (Exception $e){
            $transation->rollBack();

            echo $e->getMessage();
        }





    }

    public function actionSuccess(){
        return $this->render('success');
    }





}
