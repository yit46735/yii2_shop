<?php
use xj\uploadify\UploadAction;
use yii\web\JsExpression;

$form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'name')?>
<?=$form->field($model,'goods_category_id')->hiddenInput()?>
<?='<ul id="treeDemo" class="ztree"></ul>'?>
<?=$form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getBrandOptions(),['prompt'=>'请选择品牌分类'])?>
<?=$form->field($model,'market_price')?>
<?=$form->field($model,'shop_price')?>
<?=$form->field($model,'stock')?>
<?=$form->field($model,'is_on_sale',['inline'=>true])->radioList(\backend\models\Goods::$on_sale_options)?>
<?=$form->field($model,'status',['inline'=>true])->radioList(\backend\models\Goods::$status_options)?>
<?=$form->field($model,'logo_file')->fileInput()?>
<?php
if($model->logo){
    echo \yii\helpers\Html::img('@web/'.$model->logo,['width'=>50]);
}
?>
<?=$form->field($model,'sort')?>
<?=$form->field($goodsIntro,'content')->widget(\crazyfd\ueditor\Ueditor::className(),[])?>
<?=\yii\helpers\Html::submitInput('提交',['class'=>'btn btn-info'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
<?php
$this->registerCssFile('@web/zTree/css/metroStyle/metroStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNodes=\yii\helpers\Json::encode($categories);
$js = new \yii\web\JsExpression(
    <<<JS
    var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback: {
		onClick: function (event, treeId, treeNode) {
		        $('#goods-goods_category_id').val(treeNode.id);
		        console.debug(treeNode.id);
            }
	}
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$zNodes};

    zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    zTreeObj.expandAll(true);



JS

);
$this->registerJs($js);
?>
