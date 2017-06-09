<?php $form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'name')?>
<?=$form->field($model,'intro')->textarea()?>
<?=$form->field($model,'sort')?>
<?=$form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'隐藏'])?>
<?=$form->field($model,'is_help')?>
<?=\yii\helpers\Html::submitInput('提交',['class'=>'btn btn-info'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
