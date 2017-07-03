<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>商城用户订单管理</strong></div>
            <table class="table table-bordered table-hover table-striped text-center">
                <tr class="info">
                    <th>订单编号</th>
                    <th>收货人</th>
                    <th>地址</th>
                    <th>电话</th>
                    <th>配送方式</th>
                    <th>付款方式</th>
                    <th>总价</th>
                    <th>状态</th>
                    <th>时间</th>
                    <th>操作</th>
                </tr>
                <?php foreach($models as $model):?>
                    <tr>
                        <td><?=$model->trade_no?></td>
                        <td><?=$model->name?></td>
                        <td><?=$model->province.$model->city.$model->area.'</br>'.$model->address?></td>
                        <td><?=$model->tel?></td>
                        <td><?=$model->delivery_name.'</br>¥'.$model->delivery_price?></td>
                        <td><?=$model->payment_name?></td>
                        <td><?=$model->total?></td>
                        <td style="color:<?=\frontend\models\Order::$color[$model->status]?>"><?=\frontend\models\Order::$status[$model->status]?></td>
                        <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
                        <td>
                            <p><a href="<?=\yii\helpers\Url::to(['order/deliver','id'=>$model->id])?>" class="btn btn-primary btn-xs">发货</a></p>
                            <a href="<?=\yii\helpers\Url::to(['order/finish','id'=>$model->id])?>" class="btn btn-success btn-xs">完成</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</div>



