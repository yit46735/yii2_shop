<style type="text/css">
    .field-province,.field-city,.field-area{
        display: inline-block;
    }
    .field-address-status label{
        width: 100px;
    }
    .btn{
        position: relative;
        top: -6px;
    }
</style>

<!-- 页面主体 start -->
<div class="main w1210 bc mt10">
    <div class="crumb w1210">
        <h2><strong>我的XX </strong><span>> 我的订单</span></h2>
    </div>
<!-- 左侧导航菜单 start -->
<div class="menu fl">
    <h3>我的XX</h3>
    <div class="menu_wrap">
        <dl>
            <dt>订单中心 <b></b></dt>
            <dd><b>.</b><a href="">我的订单</a></dd>
            <dd><b>.</b><a href="">我的关注</a></dd>
            <dd><b>.</b><a href="">浏览历史</a></dd>
            <dd><b>.</b><a href="">我的团购</a></dd>
        </dl>

        <dl>
            <dt>账户中心 <b></b></dt>
            <dd class="cur"><b>.</b><a href="">账户信息</a></dd>
            <dd><b>.</b><a href="">账户余额</a></dd>
            <dd><b>.</b><a href="">消费记录</a></dd>
            <dd><b>.</b><a href="">我的积分</a></dd>
            <dd><b>.</b><a href="">收货地址</a></dd>
        </dl>

        <dl>
            <dt>订单中心 <b></b></dt>
            <dd><b>.</b><a href="">返修/退换货</a></dd>
            <dd><b>.</b><a href="">取消订单记录</a></dd>
            <dd><b>.</b><a href="">我的投诉</a></dd>
        </dl>
    </div>
</div>
<!-- 左侧导航菜单 end -->

<!-- 右侧内容区域 start -->
<div class="content fl ml10">
    <div class="address_hd">
        <h3>收货地址薄</h3>
        <dl>
            <?php foreach($Lists as $List):?>
                <dt>
                    <?=$List->username?>
                    <?=\frontend\models\Locations::findOne(['id'=>$List->province])->name?>
                    <?=\frontend\models\Locations::findOne(['id'=>$List->city])->name?>
                    <?=\frontend\models\Locations::findOne(['id'=>$List->area])->name?>
                    <?=$List->address?>
                    <?=$List->tel?>
                </dt>
                <dd>
                    <?=\yii\helpers\Html::a('修改',['address/edit','id'=>$List->id])?>
                    <?=\yii\helpers\Html::a('删除',['address/delete','id'=>$List->id])?>
                    <?=$List->status==1?'默认地址':\yii\helpers\Html::a('设为默认地址',['address/default','id'=>$List->id])?>
                </dd>
            <?php endforeach;?>
        </dl>

    </div>

    <div class="address_bd mt10">
        <h4>新增收货地址</h4>
                <?php $form = \yii\widgets\ActiveForm::begin(

                        ['fieldConfig'=>[
                        'options'=>[
                            'tag'=>'li',
                        ],
                        'errorOptions'=>[
                            'tag'=>'span'
                        ]

                    ]]
                    )?>
                    <?='<ul>'?>
                    <?=$form->field($model,'username')->textInput(['class'=>'txt'])?>

                    <?= $form->field($model,'province')->dropDownList($model->getCityList(0),
                        [
                            'id'=>'province',
                            'prompt'=>'--请选择省--',
                            'onchange'=>'
            $("select[id=city]").get(0).length=1;
            $("select[id=area]").get(0).length=1;
            if($(this).val().length==0){
                return;
            }
            $.post("'.yii::$app->urlManager->createUrl('address/site').'?typeid=1&pid="+$(this).val(),function(data){
                $("select#city").html(data);
            });',
                        ]) ?>

                    <?= $form->field($model, 'city')->dropDownList($model->getCityList($model->province),
                        [
                            'id'=>'city',
                            'prompt'=>'--请选择市--',
                            'onchange'=>'
            $("select[id=area]").get(0).length=1;
             if($(this).val().length==8){
                return;
            }
            $.post("'.yii::$app->urlManager->createUrl('address/site').'?typeid=2&pid="+$(this).val(),function(data){
                $("select#area").html(data);
            });',
                        ])->label(false) ?>
                    <?= $form->field($model, 'area')->dropDownList($model->getCityList($model->city),['id'=>'area','prompt'=>'--请选择区--',])->label(false) ?>
                    <?=$form->field($model,'address')->textInput(['class'=>'txt'])?>
                    <?=$form->field($model,'tel')->textInput(['class'=>'txt'])?>
                    <?=$form->field($model,'status')->checkbox(['class'=>'check'])?>
                    <?=\yii\helpers\Html::submitInput('保存',['class'=>'btn'])?>
                    <?php \yii\widgets\ActiveForm::end();?>
    </div>

</div>
<!-- 右侧内容区域 end -->
</div>
<!-- 页面主体 end-->
<?php
//$this->registerJsFile('@web/js/jquery-1.8.3.min.js');
//$js=new \yii\web\JsExpression(
//    <<<JS
//    //因为当页面加载完毕就需要展示出所有省份列表，所以先创建一个匿名函数
//			$(function(){
//				//因为需要使用ajax请求php,所以定义一个json参数data
//				var data={pid:0};
//				//创建ajax请求php
//				$.getJSON('add',data,function(response){
//					//因为回调函数里面的response数据是一个二维数组，所以需要使用遍历取值
//					$(response).each(function(i,v){
//						//因为取得的值需要展示在页面上，所以定义一个局部变量保存html语句
//						var html = '<option value="' + v.id + '">' + v.name + '</option>';
//						//因为需要将拼凑好的html语句解析并展示在页面上，所以使用jquery对象追加在对应的节点上
//						$(html).appendTo('select[name=Address[province]]');
//					});
//				})
//
//				//因为需要在选择省份以后读取对应的市，所以在省份节点上绑定事件函数
//				$('select[name=province]').on('change',function(){
//					//因为读取市的数据需要对应的省份ID，所以创建局部变量保存对应省的ID
//					var id=$('select[name=province] option:selected').val();
//					//因为ajax请求php需要传参去数据库读取对应的值，所以定义一个可变的ID值
//					var data={pid:id};
//					//因为在改变省份以后需要刷新市信息，所以在ajax请求php读取信息前删除上一次读取的市数据
//					$('select[name=city]').get(0).length=1;
//					//因为在改变省份以后需要刷新地区信息，所以在ajax请求php读取信息前删除上一次读取的地区数据
//					$('select[name=area]').get(0).length=1;
//					//因为当不选择任何省份时不能读取数据，所以需要判断选择的option对应值的长度，如果为0则代表未选任何省，则return终止后续代码的执行
//					if($(this).val().length==0){
//						//因为需要返回且下面代码不需要执行，所以直接return
//						return;
//					}
//					//创建ajax请求php
//					$.getJSON('www.yii2shop.com/address/add.html', data, function(response) {
//						//因为回调函数里面的response数据是一个二维数组，所以需要使用遍历取值
//						$(response).each(function(i, v) {
//							//因为取得的值需要展示在页面上，所以定义一个局部变量保存html语句
//							var html = '<option value="' + v.id + '">' + v.name + '</option>';
//							//因为需要将拼凑好的html语句解析并展示在页面上，所以使用jquery对象追加在对应的节点上
//							$(html).appendTo('select[name=city]');
//						});
//
//					});
//				});
//
//				//因为需要在选择市以后读取对应的地区，所以在市节点上绑定事件函数
//				$('select[name=city]').on('change',function(){
//					//因为读取地区的数据需要对应的市ID，所以创建局部变量保存对应市的ID
//					var id=$('select[name=city] option:selected').val();
//					//因为ajax请求php需要传参去数据库读取对应的值，所以定义一个json格式的变量保存ID值
//					var data={pid:id};
//					//因为在改变市以后需要刷新地区信息，所以在ajax请求php读取信息前删除上一次读取的地区数据
//					$('select[name=area]').get(0).length=1;
//					//因为当不选择任何市时不能读取数据，所以需要判断选择的option对应值的长度，如果为0则代表未选任何市，则return终止后续代码的执行
//					if($(this).val().length==0){
//						//因为需要返回且下面代码不需要执行，所以直接return
//						return;
//					}
//					//创建ajax请求php
//					$.getJSON('www.yii2shop.com/address/add.html', data, function(response) {
//						//因为回调函数里面的response数据是一个二维数组，所以需要使用遍历取值
//						$(response).each(function(i, v) {
//							//因为取得的值需要展示在页面上，所以定义一个局部变量保存html语句
//							var html = '<option value="' + v.id + '">' + v.name + '</option>';
//							//因为需要将拼凑好的html语句解析并展示在页面上，所以使用jquery对象追加在对应的节点上
//							$(html).appendTo('select[name=area]');
//						});
//
//					});
//				});
//			});
//JS
//
//);
//$this->registerJs($js);