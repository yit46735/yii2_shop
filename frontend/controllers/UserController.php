<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\LoginForm;
use frontend\models\Member;

class UserController extends \yii\web\Controller
{
    public $layout='login';


    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,
                'maxLength'=>4,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegister(){

        $model=new Member();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save(false);

        }

        return $this->render('register',['model'=>$model]);

    }

    public function actionLogin(){



        $model=new LoginForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->login()){
                $member=Member::findOne(['username'=>$model->username]);
                $member->last_login_time=time();
                $member->last_login_ip=ip2long(\Yii::$app->request->userIP);
                $member->save(false);


                return $this->goBack();
            }
        }

            \Yii::$app->user->setReturnUrl(\Yii::$app->request->referrer);

            return $this->render('login',['model'=>$model]);

    }



    public function actionLogout(){
        \Yii::$app->user->logout();
        return $this->redirect(['user/login']);
    }





}
