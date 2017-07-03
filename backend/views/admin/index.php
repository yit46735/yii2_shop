<style type="text/css">
    th{
        text-align: center;
    }
    .btn-success{
        margin-left: 10px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>用户管理</strong></div>
            <table class="table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>ID</th>
                    <th>用户名</th>
                    <th>角色</th>
                    <th>性别</th>
                    <th>头像</th>
                    <th>登录IP</th>
                    <th>注册时间</th>
                    <th>最后登录时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                <?php foreach($models as $model):?>
                    <tr>
                        <td><?=$model->id?></td>
                        <td><?=$model->username?></td>
                        <td>
                            <?php
                            foreach(\Yii::$app->authManager->getRolesByUser($model->id) as $role){
                                echo $role->name;
                                echo '<br/>';
                            }
                            ?>
                        </td>
                        <td><?=$model->gender==0?'女':'男'?></td>
                        <td><img src="<?=$model->photo?>" width="50px"/></td>
                        <td><?=$model->login_ip?></td>
                        <td><?=date('Y-m-d H:i:s',$model->register_time)?></td>
                        <td><?=date('Y-m-d H:i:s',$model->login_time)?></td>
                        <td>
                            <?=$model->status==1?'<span style="color: red">离线</span>':'<span style="color: green">在线</span>'?>
                        </td>
                        <td>
                            <?=\Yii::$app->user->can('admin/edit')?\yii\helpers\Html::a('编辑',['admin/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs']):''?>
                            <?=\Yii::$app->user->can('admin/delete')?\yii\helpers\Html::a('删除',['admin/delete','id'=>$model->id],['class'=>'btn btn-danger btn-xs']):''?>
                            <?=\Yii::$app->user->can('admin/change')?\yii\helpers\Html::a('修改密码',['admin/change','id'=>$model->id],['class'=>'btn btn-warning btn-xs']):''?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <a href="<?=\yii\helpers\Url::to(['admin/add'])?>" class="btn btn-primary">添加</a>
    </div>
</div>


