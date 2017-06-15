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
            <div class="panel-heading"><strong>用户管理</strong>
                <?php if(\Yii::$app->user->isGuest){
                    echo ' <a href="'.\yii\helpers\Url::to(['admin/login']).'" class="btn btn-success">登录</a>';
                }else{
                    echo '欢迎你：'.\Yii::$app->user->identity->username.' <a href="'.\yii\helpers\Url::to(['admin/logout']).'" class="btn btn-danger">注销</a>';
                }
                ?>

            </div>
            <table class="table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>ID</th>
                    <th>用户名</th>
                    <th>性别</th>
                    <th>头像</th>
                    <th>注册时间</th>
                    <th>最后登录时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                <?php foreach($models as $model):?>
                    <tr>
                        <td><?=$model->id?></td>
                        <td><?=$model->username?></td>
                        <td><?=$model->gender==0?'女':'男'?></td>
                        <td><img src="<?=$model->photo?>"/></td>
                        <td><?=date('Y-m-d H:i:s',$model->register_time)?></td>
                        <td><?=date('Y-m-d H:i:s',$model->login_time)?></td>
                        <td>
                            <?=$model->status==1?'<span style="color: red">离线</span>':'<span style="color: green">在线</span>'?>
                        </td>
                        <td>
                            <?=\yii\helpers\Html::a('编辑',['admin/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
                            <?=\yii\helpers\Html::a('删除',['admin/delete','id'=>$model->id],['class'=>'btn btn-danger btn-xs'])?>
                            <?=\yii\helpers\Html::a('修改密码',['admin/change','id'=>$model->id],['class'=>'btn btn-warning btn-xs'])?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <a href="<?=\yii\helpers\Url::to(['admin/add'])?>" class="btn btn-primary">添加</a>
    </div>
</div>


