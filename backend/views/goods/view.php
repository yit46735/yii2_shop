<style type="text/css">
    p{
        text-indent: 2em;
    }
</style>
<div class="page-header">
    <h2>商品介绍<small>&emsp;<?=date('Y-m-d H:i:s',$model->create_time)?></small></h2>
    <h3><?=$model->name?></h3>
</div>

<div class="jumbotron">



    <p><?=$model->goodsIntro->content?></p>


</div>