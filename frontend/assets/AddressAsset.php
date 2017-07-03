<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class AddressAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/goods.css',
        'style/list.css',
        'style/common.css',
        'style/home.css',
        'style/order.css',
        'style/address.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/jqzoom.css',


    ];
    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/jqzoom-core.js',
        'js/header.js',
        'js/goods.js',
        'js/home.js',
        'js/list.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}