<?php
namespace console\controllers;



use frontend\models\Order;
use yii\console\Controller;

class TaskController extends Controller{
    public function actionClean(){
        set_time_limit(0);//不限制脚本执行时间
        while (1){
            //超时未支付订单  待支付状态1超过1小时==》已取消0
            $models = Order::find()->where(['status'=>1])->andWhere(['<','create_time',time()-3600])->all();
            foreach ($models as $model){
                //$model->status = 0;
                //$model->save();
                //返还库存
                //$model->goods 建立hasMany对应关系
                /*foreach($model->goods as $goods){
                    Goods::updateAllCounters(['stock'=>$goods->amount],'id='.$goods->goods_id);
                }*/
                echo "ID".$model->id." has been clean...\n";

            }
            //1秒钟执行一次
            sleep(1);
        }
    }
}