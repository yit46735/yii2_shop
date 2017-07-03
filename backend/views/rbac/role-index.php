<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>角色管理</strong></div>
            <table class="cate table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>角色名称</th>
                    <th>描述</th>
                    <th>权限</th>
                    <th>操作</th>
                </tr>
                <?php foreach($models as $model):?>
                    <tr>
                        <td><?=$model->name?></td>
                        <td><?=$model->description?></td>
                        <td>
                            <ol class="breadcrumb" style="width: 800px">
                            <?php
                            foreach (Yii::$app->authManager->getPermissionsByRole($model->name) as $permission){
                                echo '<li>'.$permission->description.'</li>';
                            }
                            ?>
                            </ol>
                        </td>
                        <td>
                            <?=\Yii::$app->user->can('rbac/edit-role')?\yii\helpers\Html::a('编辑',['rbac/edit-role','name'=>$model->name],['class'=>'btn btn-info btn-xs']):''?>
                            <?=\Yii::$app->user->can('rbac/delete-role')?\yii\helpers\Html::a('删除',['rbac/delete-role','name'=>$model->name],['class'=>'btn btn-danger btn-xs']):''?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <a href="<?=\yii\helpers\Url::to(['rbac/add-role'])?>" class="btn btn-primary">添加</a>
    </div>
</div>





