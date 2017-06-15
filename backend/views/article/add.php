<?php $form=\yii\bootstrap\ActiveForm::begin()?>
<?=$form->field($article,'name')?>
<?=$form->field($article,'intro')->textarea()?>
<?=$form->field($article,'article_category_id')->dropDownList(\backend\models\Article::getCategoryOptions(),['prompt'=>'=请选择分类='])?>
<?=$form->field($article,'sort')?>
<?=$form->field($article,'status',['inline'=>true])->radioList(\backend\models\Article::$status)?>
<?= $form->field($article_detail, 'content')->widget(\crazyfd\ueditor\Ueditor::className(),[]) ?>
<?=\yii\helpers\Html::submitInput('提交',['class'=>'btn btn-info'])?>
<?php \yii\bootstrap\ActiveForm::end()?>
