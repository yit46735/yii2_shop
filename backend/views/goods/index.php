<style type="text/css">
    th{
        text-align: center;
    }
    .form-control{
        width: 300px;
        display: inline-block;
    }
</style>
<?php $form=\yii\bootstrap\ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options'=>['class'=>'navbar-form navbar-left']
])?>
<div class="form-group">
    <?=\yii\helpers\Html::input('','key','',['class'=>'form-control','placeholder'=>'搜索商品名称或单号'])?>
    <?=\yii\helpers\Html::submitInput('查询',['class'=>'btn btn-default'])?>
    <a href="<?=\yii\helpers\Url::to(['goods/add'])?>" class="btn btn-default">添加</a>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>商品管理</strong></div>
            <table class="table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>ID</th>
                    <th>商品名称</th>
                    <th>货号</th>
                    <th>Logo</th>
                    <th>商品分类</th>
                    <th>品牌分类</th>
                    <th>市场价格</th>
                    <th>商品价格</th>
                    <th>库存</th>
                    <th>是否在售</th>
                    <th>状态</th>
                    <th>排序</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                <?php foreach($goodsLists as $goodsList):?>
                    <tr>
                        <td><?=$goodsList->id?></td>
                        <td><?=$goodsList->name?></td>
                        <td><?=$goodsList->sn?></td>
                        <td><?=\yii\helpers\Html::img('@web/'.$goodsList->logo,['width'=>'50px'])?></td>
                        <td><?=$goodsList->goodsCategory->name?></td>
                        <td><?=$goodsList->brand->name?></td>
                        <td><?=$goodsList->market_price?></td>
                        <td><?=$goodsList->shop_price?></td>
                        <td><?=$goodsList->stock?></td>
                        <td><?=\backend\models\Goods::$on_sale_options[$goodsList->is_on_sale]?></td>
                        <td><?=\backend\models\Goods::$status_options[$goodsList->status]?></td>
                        <td><?=$goodsList->sort?></td>
                        <td><?=date('Y-m-d H:i:s',$goodsList->create_time)?></td>
                        <td>
                            <?=\yii\helpers\Html::a('商品详情',['goods/view','id'=>$goodsList->id],['class'=>'btn btn-success btn-xs'])?>
                            <?=\yii\helpers\Html::a('商品相册',['goods/gallery','id'=>$goodsList->id],['class'=>'btn btn-primary btn-xs'])?><br/><br/>
                            <?=\Yii::$app->user->can('goods/edit')?\yii\helpers\Html::a('编辑',['goods/edit','id'=>$goodsList->id],['class'=>'btn btn-info btn-xs']):''?>
                            <?=\Yii::$app->user->can('goods/delete')?\yii\helpers\Html::a('删除',['goods/delete','id'=>$goodsList->id],['class'=>'btn btn-danger btn-xs']):''?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</div>
<div style="float: left">
    <?php \yii\bootstrap\ActiveForm::end()?>
    <?=\yii\widgets\LinkPager::widget([
        'pagination'=>$pagination,
        'nextPageLabel'=>'下一页',
        'prevPageLabel'=>'上一页',
        'firstPageLabel'=>'首页',
        'lastPageLabel'=>'末页',
    ]);
    ?>

</div>



