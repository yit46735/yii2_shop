<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息</h3>
            <div class="address_info">
                <?php foreach($models as $model):?>
                    <p><input type="radio" value="<?=$model->id?>" name="address_id" <?=$model->status==1?'checked':''?>/>
                        <?=$model->username?>
                        <?=$model->tel?>
                        <?=$model->provinceName->name?>
                        <?=$model->cityName->name?>
                        <?=$model->areaName->name?>
                        <?=$model->address?>
                    </p>
                <?php endforeach;?>
            </div>


        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 </h3>


            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach(\frontend\models\Order::$deliveries as $key=>$delivery):?>
                        <tr <?=$key==0?"class='cur'":''?>>
                            <td><input type="radio" name="delivery" value="<?=$delivery['id']?>"/><?=$delivery['name']?></td>
                            <td>￥<span class="yf"><?=number_format($delivery['price'],2)?></span></td>
                            <td><?=$delivery['info']?></td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>

            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>


            <div class="pay_select">
                <table>
                    <?php foreach(\frontend\models\Order::$payments as $key=>$payment):?>
                        <tr <?=$key==0?"class='cur'":''?>>
                            <td class="col1"><input type="radio" name="pay" value="<?=$payment['id']?>"/><?=$payment['name']?></td>
                            <td class="col2"><?=$payment['info']?></td>
                        </tr>
                    <?php endforeach;?>
                </table>

            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <!--<div class="receipt none">
            <h3>发票信息 </h3>


            <div class="receipt_select ">
                <form action="">
                    <ul>
                        <li>
                            <label for="">发票抬头：</label>
                            <input type="radio" name="type" checked="checked" class="personal" />个人
                            <input type="radio" name="type" class="company"/>单位
                            <input type="text" class="txt company_input" disabled="disabled" />
                        </li>
                        <li>
                            <label for="">发票内容：</label>
                            <input type="radio" name="content" checked="checked" />明细
                            <input type="radio" name="content" />办公用品
                            <input type="radio" name="content" />体育休闲
                            <input type="radio" name="content" />耗材
                        </li>
                    </ul>
                </form>

            </div>
        </div>-->
        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php $sum=0; ?>
                <?php foreach($carts as $cart):?>
                    <tr>
                        <td class="col1"><a href=""><img src="http://admin.yii2shop.com/<?=$cart->goods->logo?>" alt="" width="50px"/></a>  <strong><a href=""><?=$cart->goods->name?></a></strong></td>
                        <td class="col3">￥<?=number_format($cart->goods->shop_price,2)?></td>
                        <td class="col4"> <?=$cart->amount?></td>
                        <td class="col5"><?php $sum+=($cart->goods->shop_price*$cart->amount)?><span>￥<?=number_format(($cart->goods->shop_price)*($cart->amount),2)?></span></td>
                    </tr>
                <?php endforeach;?>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?=count($carts)?> 件商品，总商品金额：</span>
                                <em>￥<span id="goods_money"><?=$sum?></span></em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em>￥0.00</em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em>￥<span id="yf">10.00</span></em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥<span class="total"><?=number_format($sum+10,2)?></span></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <a href="javascript:void(0)"><span>提交订单</span></a>
        <p>应付总额：<strong>￥<span class="total"><?=number_format($sum+10,2)?></span></strong></p>

    </div>
</div>
<!-- 主体部分 end -->
<?php
/**
 * @var $this \yii\web\View
 */
$url = \yii\helpers\Url::to(['order/add']);
$a=\yii\helpers\Url::to(['order/success']);
$token = \Yii::$app->request->csrfToken;
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
    $("input[name='delivery']").click(function(){
        var money=$(this).closest('tr').find('.yf').html();
        $('#yf').html(money);
        var goods_money=$('#goods_money').html();
        //console.debug(goods_money);
        $('.total').html(goods_money*1+money*1);
    });

    $('.fillin_ft').find('a').click(function(){
        var address_id=$("input[name='address_id']:checked").val();
        var delivery_id=$("input[name='delivery']:checked").val();
        var payment_id=$("input[name='pay']:checked").val();
        var total=$('.total').html();
        var data={'total':total,'address_id':address_id,'delivery_id':delivery_id,'payment_id':payment_id,"_csrf-frontend":"$token"};
        $.post("$url",data,function(data){
            if(data == 'success'){
                $(location).attr('href', 'http://www.yii2shop.com/order/success.html');

            }else{
                //console.log(data);
                alert(data);
            }
        });

    });

JS

));