<?php

namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsIntro;
use frontend\components\SphinxClient;
use frontend\models\Address;
use frontend\models\Locations;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
use yii\helpers\Url;

class AddressController extends \yii\web\Controller
{
    public $layout='address';

    public function actionDefault($id)
    {
        $models=Address::find()->where(['user_id'=>\Yii::$app->user->getId()])->all();
        if($models){
            foreach($models as $model){
                $model->status=0;
                $model->save();
            }

            $model=Address::findOne($id);
            $model->status=1;
            $model->save();
            return $this->redirect(['address/add']);
        }



    }

    public function actionAdd()
    {

        if(\Yii::$app->user->isGuest){
            return $this->redirect(Url::to(['user/login']));
        }
        $model = new Address();

        if($model->load(\Yii::$app->request->post()) && $model->validate()){


            $model->save();
            return $this->redirect(['address/add']);


        }

        $Lists=Address::find()->where(['user_id'=>\Yii::$app->user->identity->id])->all();

        return $this->render('add',['model'=>$model,'Lists'=>$Lists]);
    }

    public function actionEdit($id){

        $model=Address::findOne($id);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){


            $model->save();
            return $this->redirect(['address/add']);


        }

        $Lists=Address::find()->where(['user_id'=>\Yii::$app->user->identity->id])->all();

        return $this->render('add',['model'=>$model,'Lists'=>$Lists]);

    }

    public function actionDelete($id){
        $model=Address::findOne($id);
        if($model){
            $model->delete();
            return $this->redirect(['address/add']);
        }

        $Lists=Address::find()->where(['user_id'=>\Yii::$app->user->identity->id])->all();

        return $this->render('add',['model'=>$model,'Lists'=>$Lists]);
    }

    public function actionSite($pid, $typeid = 0)
    {
        $model = new Address();
        $model = $model->getCityList($pid);

        if($typeid == 1){
            $aa="--请选择市--";
            echo Html::tag('option',$aa, ['value'=>null]) ;
        }else if($typeid == 2 && $model){
            $aa="--请选择区--";
            echo Html::tag('option',$aa, ['value'=>null]) ;
        }


        foreach($model as $value=>$name)
        {
            echo Html::tag('option',Html::encode($name),array('value'=>$value));
        }
    }

    public function actionList($id){
        $category=GoodsCategory::findOne($id);
        $children=$category->children;
        if($children){
            $goods_category_ids=[];
            foreach($children as $child){
                $cate=$child->children;
                if($cate){
                    foreach($cate as $child){
                        $goods_category_ids[]=$child->id;
                    }
                }
                $goods_category_ids[]=$child->id;
            }
            $query=Goods::find()->where(['goods_category_id'=> $goods_category_ids]);
        }else{
            $query=Goods::find()->where(['goods_category_id'=> $id]);
        }

        $total=$query->count();
        $page=new Pagination(['totalCount'=>$total,'defaultPageSize'=>8]);
        $goodsLists=$query->offset($page->offset)->limit($page->limit)->all();

        return $this->render('list',['goodsLists'=>$goodsLists,'page'=>$page]);
    }

    public function actionGoods($id){

        $model=Goods::findOne(['id'=>$id]);

        return $this->render('goods',['model'=>$model]);
    }

    public function actionTest(){
      /*  // 配置信息
        $config = [
            'app_key'    => '24479141',
            'app_secret' => 'd3c7487718af008a4905da076f219c95',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];


// 使用方法一
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum('15608058683')
            ->setSmsParam([
                'code' => rand(1000, 9999),
                'name'=>'易腾'
            ])
            ->setSmsFreeSignName('易腾的个人网站')
            ->setSmsTemplateCode('SMS_71545183');

        $resp = $client->execute($req);*/

        $tel=\Yii::$app->request->post('tel');
        $name=\Yii::$app->request->post('name');
        if(!preg_match('/^1[34578]\d{9}$/',$tel)){
            echo '电话不正确';
            exit;
        }
        $code = rand(1000,9999);
//        $result = \Yii::$app->sms->setNum($tel)->setParam(['code' => $code,'name'=>$name])->send();
        $result=1;
        if($result){
            \Yii::$app->cache->set('tel_'.$tel,$code,5*60);

//            echo $code.'发送成功';
            echo 'success'.$code;
        }else{
            echo '发送失败';
        }
    }


    public function actionMyOrder(){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(Url::to(['user/login']));
        }
        $orders=[];
        foreach(Order::find()->where(['member_id'=>\Yii::$app->user->getId()])->all() as $order){

            $ordergoods=OrderGoods::find()->where(['order_id'=>$order->id])->one();

            if($ordergoods){
                $orders[]=$ordergoods;
            }

        }
        return $this->render('myorder',['orders'=>$orders]);
    }

    public function actionSearch(){
        $cl = new SphinxClient();
        $cl->SetServer ( '127.0.0.1', 9312);
//$cl->SetServer ( '10.6.0.6', 9312);
//$cl->SetServer ( '10.6.0.22', 9312);
//$cl->SetServer ( '10.8.8.2', 9312);
        $cl->SetConnectTimeout ( 10 );
        $cl->SetArrayResult ( true );
// $cl->SetMatchMode ( SPH_MATCH_ANY);
        $cl->SetMatchMode ( SPH_MATCH_ALL);
        $cl->SetLimits(0, 1000);
        $info = '雪碧饮料';
        $res = $cl->Query($info, 'goods');//shopstore_search
//print_r($cl);
        var_dump($res);

    }

    public function actionView(){
        $query=Goods::find();
//        var_dump(\Yii::$app->request->get('keyword'));exit;
        if($keyword=\Yii::$app->request->get('keyword')){
            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode ( SPH_MATCH_ALL);
            $cl->SetLimits(0, 1000);
            $res = $cl->Query($keyword, 'goods');//shopstore_search
            if(!isset($res['matches'])){
                $query->where(['id'=>0]);
            }else{
                $ids=ArrayHelper::map($res['matches'],'id','id');
                $query->where(['in','id',$ids]);

            }
        }
        $Lists=$query->all();
        $keywords = array_keys($res['words']);
        $options = array(
            'before_match' => '<span style="color:red;">',
            'after_match' => '</span>',
            'chunk_separator' => '...',
            'limit' => 80, //如果内容超过80个字符，就使用...隐藏多余的的内容
        );
//关键字高亮
//        var_dump($models);exit;
        foreach ($Lists as $index => $item) {
            $name = $cl->BuildExcerpts([$item->name], 'goods', implode(',', $keywords), $options); //使用的索引不能写*，关键字可以使用空格、逗号等符号做分隔，放心，sphinx很智能，会给你拆分的
            $Lists[$index]->name = $name[0];
//            var_dump($name);
        }

         return $this->render('view',['Lists'=>$Lists]);

    }




}
