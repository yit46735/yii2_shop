<?php $form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'roles')->checkboxList(\backend\models\UserForm::getRoleOptions())?>
<?=\yii\helpers\Html::submitInput('提交',['class'=>'btn btn-info'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
