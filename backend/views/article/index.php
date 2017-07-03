<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>文章管理</strong></div>
            <table class="table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>ID</th>
                    <th>文章名称</th>
                    <th>文章简介</th>
                    <th>文章分类</th>
                    <th>排序</th>
                    <th>状态</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                <?php foreach($articleLists as $articleList):?>
                    <tr>
                        <td><?=$articleList->id?></td>
                        <td><?=$articleList->name?></td>
                        <td><?=$articleList->intro?></td>
                        <td><?=$articleList->category->name?></td>
                        <td><?=$articleList->sort?></td>
                        <td><?=\backend\models\Article::$status[$articleList->status]?></td>
                        <td><?=date('Y-m-d H:i:s',$articleList->create_time)?></td>
                        <td>
                            <?=\yii\helpers\Html::a('文章详情',['article/view','id'=>$articleList->id],['class'=>'btn btn-success btn-xs'])?>
                            <?=\Yii::$app->user->can('article/edit')?\yii\helpers\Html::a('编辑',['article/edit','id'=>$articleList->id],['class'=>'btn btn-info btn-xs']):''?>
                            <?=\Yii::$app->user->can('article/delete')?\yii\helpers\Html::a('删除',['article/delete','id'=>$articleList->id],['class'=>'btn btn-danger btn-xs']):''?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <a href="<?=\yii\helpers\Url::to(['article/add'])?>" class="btn btn-primary">添加</a>
    </div>
</div>


