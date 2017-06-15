

<?php
/**
 * @var $this \yii\web\view
 */
$form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'name')?>
<?=$form->field($model,'parent_id')->hiddenInput()?>
<?='<ul id="treeDemo" class="ztree"></ul>'?>
<?=$form->field($model,'intro')->textarea()?>
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
		        $('#goodscategory-parent_id').val(treeNode.id);
		        console.debug(treeNode.id);
            }
	}
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$zNodes};

    zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    zTreeObj.expandAll(true);

    var node = zTreeObj.getNodeByParam("id",$('#goodscategory-parent_id').val(),null);
    zTreeObj.selectNode(node);

JS

);
$this->registerJs($js);
?>

