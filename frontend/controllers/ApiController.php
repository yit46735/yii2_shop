<?php
namespace frontend\controllers;

use backend\models\Admin;
use backend\models\ChangeForm;
use backend\models\GoodsCategory;
use frontend\models\Address;
use frontend\models\Locations;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\base\Response;
use yii\web\Controller;

class ApiController extends Controller{

    public $enableCsrfValidation=false;

    /**
     *
     */
    public function init(){

        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        parent::init();
    }


    //注册接口
    public function actionRegister(){

        $request=\Yii::$app->request;

        if($request->isPost){
            $member=new Member();
            $member->username=$request->post('username');
            $member->password=$request->post('password');
            $member->email=$request->post('email');
            $member->tel=$request->post('tel');
            if($member->validate()){
                $member->save();
                return ['status'=>'1','msg'=>'','data'=>$member->toArray()];
            }
            return ['status'=>'-1','msg'=>$member->getErrors()];
        }
        return ['status'=>'-1','msg'=>'请使用post请求'];

    }

    //登录接口
    public function actionLogin(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $model=new LoginForm();
            $model->password=$request->post('password');
            $model->username=$request->post('username');
            $model->remember=$request->post('remember');
            if($model->login()){
                $member=Member::findOne(['username'=>$model->username]);
                $member->last_login_time=time();
                $member->last_login_ip=ip2long(\Yii::$app->request->userIP);
                if($model->validate()){
                    $member->save(false);
                    return ['status'=>'1','msg'=>'','data'=>$model->toArray()];
                }

            }
            return ['status'=>'-1','msg'=>$model->getErrors()];


        }
        return ['status'=>'-1','msg'=>'请使用post请求'];
    }

    //修改密码接口
    public function actionChange(){
        $id=\Yii::$app->user->getId();
        $model=new ChangeForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->oldpassword=$request->post('oldpassword');
            $model->password=$request->post('password');
            $model->confirm_pwd=$request->post('confirm_pwd');
            if($model->check_pwd($id)){
                $admin=Admin::findOne($id);
                if($model->validate()){
                    $admin->password_hash=\Yii::$app->security->generatePasswordHash($model->password);

                    $admin->save();
                    return ['status'=>'1','msg'=>'','data'=>$admin->toArray()];
                }

            }
            return ['status'=>'-1','msg'=>$model->getErrors()];
        }
        return ['status'=>'-1','msg'=>'请使用post请求'];

    }

    //当前登录用户信息接口
    public function actionInfo(){

        $id=\Yii::$app->user->getId();
        $member=Member::findOne($id);
        if($member){
            return ['status'=>'1','msg'=>'','data'=>$member->toArray()];
        }else{
            return ['status'=>'-1','msg'=>$member->getErrors()];
        }
    }

    //收货地址
    public function actionAddAddress(){

        $request=\Yii::$app->request;
        if($request->isPost){
            $address=new Address();
            $address->user_id=\Yii::$app->user->getId();
            $address->username=$request->post('username');
            $address->address=$request->post('address');
            $address->tel=$request->post('tel');
            $address->status=0;
            $address->province=Locations::findOne($request->post('province'))->name;
            $address->city=Locations::findOne($request->post('city'))->name;
            $address->area=Locations::findOne($request->post('area'))->name;
            if($address->validate()){
                $address->save();
                return ['status'=>'1','msg'=>'','data'=>$address->toArray()];
            }
            return ['status'=>'-1','msg'=>$address->getErrors()];
        }

        return ['status'=>'-1','msg'=>'请使用post请求'];
    }

    public function actionEditAddress(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $address=Address::findOne(['id'=>$request->post('id')]);
            $address->address=$request->post('address');
            $address->province=$request->post('province');
            $address->city=$request->post('city');
            $address->area=$request->post('area');
            if($address->validate()){
                $address->save();
                return ['status'=>'1','msg'=>'','data'=>$address->toArray()];
            }
            return ['status'=>'-1','msg'=>$address->getErrors()];
        }
        return ['status'=>'-1','msg'=>'请使用post请求'];
    }

    //删除地址接口
    public function actionDeleteAddress(){
        if($id=\Yii::$app->request->get('id')){
            $address=Address::findOne($id);
            $address->delete();
            return ['status'=>'1','msg'=>'删除成功'];
        }
        return ['status'=>'-1','msg'=>'参数不正确'];
    }

    //地址列表接口
    public function actionAddressList(){
        $id=\Yii::$app->user->getId();
        $address=Address::find(['user_id'=>$id])->asArray()->all();
        if($address){
            return ['status'=>'1','msg'=>'','data'=>$address];
        }
        return ['status'=>'-1','msg'=>'参数不正确'];
    }

    public function actionGoodsCategory(){
        $models=GoodsCategory::find()->asArray()->all();
        if($models){
            return ['status'=>'1','msg'=>'','data'=>$models];
        }
        return ['status'=>'-1','msg'=>'参数不正确'];
    }
}