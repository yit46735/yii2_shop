<?php $form = \yii\bootstrap\ActiveForm::begin([
    'action' => ['test'],
    'method' => 'get',
    'id' => 'cateadd-form',
    'options' => ['class' => 'form-horizontal'],
]); ?>

<?= $form->field($searchModel, 'name',[
    'options'=>['class'=>''],
    'inputOptions' => ['placeholder' => '搜索','class' => 'input-sm form-control'],
])->label(false) ?>
    <span class="input-group-btn">
    <?= \yii\helpers\Html::submitInput('Go!', ['class' => 'btn btn-sm btn-primary']) ?>
</span>
<?php \yii\bootstrap\ActiveForm::end(); ?>
<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'layout'=> '{items}<div class="text-right tooltip-demo">{pager}</div>',
    'pager'=>[
        //'options'=>['class'=>'hidden']//关闭自带分页
        'firstPageLabel'=>"First",
        'prevPageLabel'=>'Prev',
        'nextPageLabel'=>'Next',
        'lastPageLabel'=>'Last',
    ],
    ]);