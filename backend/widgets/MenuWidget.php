<?php
namespace backend\widgets;

use backend\models\Menu;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Widget;
use yii;

class MenuWidget extends Widget{
    /**
     *
     */
    public function init(){

        parent::init();

    }

    public function run(){
        NavBar::begin([
            'brandLabel' => '商城后台管理系统',
            'brandUrl' => \Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',

            ],
        ]);
        $menuItems = [
            ['label' => '首页', 'url' => ['admin/index']],
        ];
        if (\Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '登录', 'url' => \Yii::$app->user->loginUrl];
        } else {
            $menuItems[] = ['label' => '注销('.\Yii::$app->user->identity->username.')', 'url' => ['admin/logout']];
        }
        $menus=Menu::findAll(['parent_id'=>0]);
        foreach($menus as $menu){
            $item=['label'=>$menu->label,'items'=>[]];
            foreach($menu->children as $child){
                if(\Yii::$app->user->can($child->url)){

                    $item['items'][]=['label'=>$child->label,'url'=>[$child->url]];
                }
            }
            if(!empty($item['items'])){

                $menuItems[]=$item;
            }
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    }
}