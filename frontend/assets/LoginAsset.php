<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class LoginAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/success.css',
        'style/fillin.css',
        'style/cart.css',
        'style/login.css',
        'style/footer.css',
    ];
    public $js = [
//        'js/jquery-1.8.3.min.js',
        'js/cart1.js',
        'js/cart2.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

