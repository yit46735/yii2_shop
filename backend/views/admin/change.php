<?php
$form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'oldpassword')->passwordInput()?>
<?=$form->field($model,'password')->passwordInput()?>
<?=$form->field($model,'confirm_pwd')->passwordInput()?>
<?=\yii\helpers\Html::submitInput('修改',['class'=>'btn btn-primary'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
