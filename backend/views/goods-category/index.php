<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>商品分类管理</strong></div>
            <table class="cate table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>ID</th>
                    <th>名称</th>
                    <th>上级分类</th>
                    <th>简介</th>
                    <th>操作</th>
                </tr>
                <?php foreach($models as $model):?>
                    <tr data-tree="<?=$model->tree?>" data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>">
                        <td><?=$model->id?></td>
                        <td align="left"><?=str_repeat('- - ',$model->depth*2).$model->name?><span class="toggle glyphicon glyphicon-menu-down" style="float: right"></span></td>
                        <td><?=$model->parent_id?$model->parent->name:'顶级分类'?></td>
                        <td><?=$model->intro?></td>
                        <td>
                            <?=\Yii::$app->user->can('goods-category/edit')?\yii\helpers\Html::a('编辑',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs']):''?>
                            <?=\Yii::$app->user->can('goods-category/delete')?\yii\helpers\Html::a('删除',['goods-category/delete','id'=>$model->id],['class'=>'btn btn-danger btn-xs']):''?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <a href="<?=\yii\helpers\Url::to(['goods-category/add'])?>" class="btn btn-primary">添加</a>
    </div>
</div>

<?php
$js=new \yii\web\JsExpression(
    <<<JS


    $('.toggle').click(function(){
    var tr=$(this).closest('tr');
    var tree=parseInt(tr.attr('data-tree'));
    var lft=parseInt(tr.attr('data-lft'));
    var rgt=parseInt(tr.attr('data-rgt'));

    var show=$(this).hasClass('glyphicon-menu-up');

    $(this).toggleClass('glyphicon-menu-up');
    $(this).toggleClass('glyphicon-menu-down');

        $('.cate tr').each(function(){
            if(parseInt($(this).attr('data-tree'))==tree && parseInt($(this).attr('data-lft'))>lft && parseInt($(this).attr('data-rgt'))<rgt){
                show?$(this).fadeIn():$(this).fadeOut();

            }
        });

    });
JS

);
$this->registerJs($js);




