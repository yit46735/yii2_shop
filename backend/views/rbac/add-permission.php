<?php $form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'name')?>
<?=$form->field($model,'description')->textarea()?>
<?=\yii\helpers\Html::submitInput('提交',['class'=>'btn btn-info'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
