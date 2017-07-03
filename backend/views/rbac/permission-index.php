<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>权限管理</strong></div>
            <table id="myTable" class="cate table table-bordered table-hover table-striped text-center">
                <thead>
                <tr class="info">
                    <th>权限名称</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($models as $model):?>
                    <tr>
                        <td><?=$model->name?></td>
                        <td><?=$model->description?></td>
                        <td>
                            <?=\Yii::$app->user->can('rbac/edit-permission')?\yii\helpers\Html::a('编辑',['rbac/edit-permission','name'=>$model->name],['class'=>'btn btn-info btn-xs']):''?>
                            <?=\Yii::$app->user->can('rbac/delete-permission')?\yii\helpers\Html::a('删除',['rbac/delete-permission','name'=>$model->name],['class'=>'btn btn-danger btn-xs']):''?>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <a href="<?=\yii\helpers\Url::to(['rbac/add-permission'])?>" class="btn btn-primary">添加</a>
    </div>
</div>
<?php
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$js=new \yii\web\JsExpression(
    <<<JS
  $(document).ready(function(){
        $('#myTable').DataTable({
        "oLanguage" : {
                "sLengthMenu": "每页显示 _MENU_ 条记录",
                "sZeroRecords": "抱歉， 没有找到",
                "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
                "sInfoEmpty": "没有数据",
                "sInfoFiltered": "(从 _MAX_ 条数据中检索)",
                "sZeroRecords": "没有检索到数据",
                 "sSearch": "搜索:",
                "oPaginate": {
                "sFirst": "首页",
                "sPrevious": "前一页",
                "sNext": "后一页",
                "sLast": "尾页"
                }

            }
        });
    });
JS

);
$this->registerJs($js);





