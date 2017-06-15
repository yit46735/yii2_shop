<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>品牌管理</strong></div>
            <table class="table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>ID</th>
                    <th>品牌名称</th>
                    <th>简介</th>
                    <th>LOGO</th>
                    <th>排序</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                <?php foreach($brandLists as $brandList):?>
                    <tr>
                        <td><?=$brandList->id?></td>
                        <td><?=$brandList->name?></td>
                        <td><?=$brandList->intro?></td>
                        <td><?=\yii\helpers\Html::img($brandList->logo,['width'=>'50px'])?></td>
                        <td><?=$brandList->sort?></td>
                        <td><?=\backend\models\Brand::$status[$brandList->status]?></td>
                        <td>
                            <?=\yii\helpers\Html::a('编辑',['brand/edit','id'=>$brandList->id],['class'=>'btn btn-info btn-xs'])?>
                            <?=\yii\helpers\Html::a('删除',['brand/delete','id'=>$brandList->id],['class'=>'btn btn-danger btn-xs'])?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <a href="<?=\yii\helpers\Url::to(['brand/add'])?>" class="btn btn-primary">添加</a>
    </div>
</div>
<?=\yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
    'firstPageLabel'=>'首页',
    'lastPageLabel'=>'末页',
]);


