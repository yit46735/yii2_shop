<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
if(!$model->password_hash){
    echo $form->field($model,'password')->passwordInput();
}
echo $form->field($model,'imgFile')->fileInput();
if($model->photo){
    echo \yii\helpers\Html::img($model->photo);
}
echo $form->field($model,'gender',['inline'=>true])->radioList(\backend\models\Admin::$status);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();