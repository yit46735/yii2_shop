<?php $form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($model,'name')?>
<?=$form->field($model,'intro')->textarea()?>
<?=$form->field($model,'imgFile')->fileInput()?>
<?php if($model->logo){echo '<img src="'.$model->logo.'" width="80px"/>';}?>
<?=$form->field($model,'sort')?>
<?=$form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'隐藏'])?>
<?=\yii\helpers\Html::submitInput('提交',['class'=>'btn btn-info'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
