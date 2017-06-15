<?php
use xj\uploadify\UploadAction;
use yii\web\JsExpression;

$form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'name')?>
<?=$form->field($model,'intro')->textarea()?>
<?=$form->field($model,'logo')->hiddenInput()//隐藏域，ID=brand-logo?>
<?php echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        $('#img_logo').attr("src",data.fileUrl).show();
        $('#edit_logo').attr("src",data.fileUrl);
        $('#brand-logo').val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);
if($model->logo){
    echo \yii\helpers\Html::img($model->logo,['height'=>'60','id'=>'edit_logo']);
}else{
    echo \yii\helpers\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>'60']);
}
?>
<?=$form->field($model,'sort')?>
<?=$form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'隐藏'])?>
<?=\yii\helpers\Html::submitInput('提交',['class'=>'btn btn-info'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
