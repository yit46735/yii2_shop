<?php $form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'label')?>
<?=$form->field($model,'url')?>
<?=$form->field($model,'parent_id')->dropDownList(\backend\models\Menu::getParentOptions(),['prompt'=>'请选择菜单'])?>
<?=$form->field($model,'sort')?>
<?=\yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
