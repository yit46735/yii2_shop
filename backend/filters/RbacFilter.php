<?php
namespace backend\filters;

use yii\base\ActionFilter;
use yii\web\HttpException;

class RbacFilter extends ActionFilter{

    public function beforeAction($action){
        $user=\Yii::$app->user;
        if(!$user->can($action->uniqueId)){
            if($user->isGuest){
                return $action->controller->redirect($user->loginUrl);
            }
            throw new HttpException(403,'你无权访问该页面');
            return false;
        }

        return parent::beforeAction($action);
    }
}