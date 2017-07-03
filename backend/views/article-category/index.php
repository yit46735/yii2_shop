<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>文章分类管理</strong></div>
            <table class="table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>ID</th>
                    <th>分类名称</th>
                    <th>简介</th>
                    <th>排序</th>
                    <th>状态</th>
                    <th>类型</th>
                    <th>操作</th>
                </tr>
                <?php foreach($categoryLists as $categoryList):?>
                    <tr>
                        <td><?=$categoryList->id?></td>
                        <td><?=$categoryList->name?></td>
                        <td><?=$categoryList->intro?></td>
                        <td><?=$categoryList->sort?></td>
                        <td><?=\backend\models\ArticleCategory::$status[$categoryList->status]?></td>
                        <td><?=$categoryList->is_help?></td>
                        <td>
                            <?=\Yii::$app->user->can('article-category/edit')?\yii\helpers\Html::a('编辑',['article-category/edit','id'=>$categoryList->id],['class'=>'btn btn-info btn-xs']):''?>
                            <?=\Yii::$app->user->can('article-category/delete')?\yii\helpers\Html::a('删除',['article-category/delete','id'=>$categoryList->id],['class'=>'btn btn-danger btn-xs']):''?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <a href="<?=\yii\helpers\Url::to(['article-category/add'])?>" class="btn btn-primary">添加</a>
    </div>
</div>


