<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>菜单管理</strong></div>
            <table class="table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>ID</th>
                    <th>名称</th>
                    <th>地址/路由</th>
                    <th>上级菜单</th>
                    <th>排序</th>
                    <th>操作</th>
                </tr>
                <?php foreach($models as $model):?>
                    <tr>
                        <td><?=$model->id?></td>
                        <td align="left"><?=str_repeat('-',$model->sort*2).$model->label?></td>
                        <td><?=$model->url?></td>
                        <td><?=$model->parent_id==0?'一级菜单':$model->parent->label?></td>
                        <td><?=$model->sort?></td>
                        <td>
                            <?=\Yii::$app->user->can('menu/edit')?\yii\helpers\Html::a('编辑',['menu/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs']):''?>
                            <?=\Yii::$app->user->can('menu/delete')?\yii\helpers\Html::a('删除',['menu/delete','id'=>$model->id],['class'=>'btn btn-danger btn-xs']):''?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <a href="<?=\yii\helpers\Url::to(['menu/add'])?>" class="btn btn-primary">添加</a>
    </div>
</div>


