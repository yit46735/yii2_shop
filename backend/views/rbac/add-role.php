<?php $form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'name')?>
<?=$form->field($model,'description')->textarea()?>
<?=$form->field($model,'permissions',['inline'=>true])->checkboxList(\backend\models\RoleForm::getPermissionOptions())?>
<?=\yii\helpers\Html::submitInput('提交',['class'=>'btn btn-info'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
