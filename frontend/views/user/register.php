<?php
use \yii\helpers\Html;
?>
<style type="text/css">
    #get_captcha{
        position: relative;
        top: -44px;
        left: 220px;
    }
</style>

<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php $form=\yii\widgets\ActiveForm::begin(
                ['fieldConfig'=>[
                    'options'=>[
                        'tag'=>'li',
                    ],
                    'errorOptions'=>[
                        'tag'=>'p'
                    ]
                ]]
            )?>
            <?= '<ul>'?>
            <?=$form->field($model,'username')->textInput(['class'=>'txt'])?>
            <?=$form->field($model,'password')->passwordInput(['class'=>'txt'])?>
            <?=$form->field($model,'re_password')->passwordInput(['class'=>'txt'])?>
            <?=$form->field($model,'email')->textInput(['class'=>'txt'])?>
            <?=$form->field($model,'tel')->textInput(['class'=>'txt'])?>
            <?=$form->field($model,'smsCode',['options'=>['class'=>'checkcode']])->textInput([
                'placeholder'=>'短信验证码',
                'name'=>'captcha',
                'disabled'=>'disabled',
                'id'=>'captcha'

            ])?>
            <input type="button"  id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>
            <?=$form->field($model,'code',['options'=>['class'=>'checkcode']])->widget(yii\captcha\captcha::className(),['captchaAction'=>'user/captcha','template'=>'{input}{image}'])?><?='<span style="position: relative;top: -44px;left: 300px">点击验证码切换</span>'?>
            <?= '<li>
                    <label for="">&nbsp;</label>
                    <input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》
                </li>'?>
            <?= '<li>
                    <label for="">&nbsp;</label>
                    <input type="submit" value="" class="login_btn">
                </li>'?>
            <?='</ul>'?>
            <?php \yii\widgets\ActiveForm::end()?>



        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->
<?php
/**
 * @var $this \yii\web\View
 */
$url = \yii\helpers\Url::to(['address/test']);
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
    $('#get_captcha').click(function(){
        //启用输入框
			$('#captcha').prop('disabled',false);

			var time=60;
			var interval = setInterval(function(){
				time--;
				if(time<=0){
					clearInterval(interval);
					var html = '获取验证码';
					$('#get_captcha').prop('disabled',false);
				} else{
					var html = time + ' 秒后再次获取';
					$('#get_captcha').prop('disabled',true);
				}

				$('#get_captcha').val(html);
			},1000);

			 var tel = $("#member-tel").val();
			 var name = $("#member-username").val();
        //AJAX post提交tel参数到 user/send-sms
        $.post('$url',{tel:tel,name:name},function(data){
            if(data == 'success'){
                console.log('短信发送成功');
                //alert('短信发送成功');
            }else{
                console.log(data);
            }
        });
    });
JS

));
