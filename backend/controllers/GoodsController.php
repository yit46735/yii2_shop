<?php

namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\GoodsSearch;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends \yii\web\Controller
{
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/logo',
                'baseUrl' => '@web/upload/logo',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                /*'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "/{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png','gif'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //图片上传成功的同时，将图片和商品关联起来
                    $model = new GoodsGallery();
                    $model->goods_id = \Yii::$app->request->post('goods_id');
                    $model->path = $action->getWebUrl();
                    $model->save();
                    $action->output['fileUrl'] = $model->path;
                    //$action->output['goods_id'] = $model->goods_id;

//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    //$action->output['Path'] = $action->getSavePath();
                    /*
                     * 将图片上传到七牛云
                     */
                    /* $qiniu = \Yii::$app->qiniu;//实例化七牛云组件
                     $qiniu->uploadFile($action->getSavePath(),$action->getFilename());//将本地图片上传到七牛云
                     $url = $qiniu->getLink($action->getFilename());//获取图片在七牛云上的url地址
                     $action->output['fileUrl'] = $url;//将七牛云图片地址返回给前端js
                    */
                },
            ],



                'ueditor' => [
                    'class' => 'crazyfd\ueditor\Upload',
                    'config'=>[
                        'uploadDir'=>date('Y/m/d')
                    ]

                ],

        ];


    }



    public function actionIndex()
    {
        //搜索
        $key=\Yii::$app->request->get('key');
        $query=Goods::find();
        //筛选关键字
        $query->andFilterWhere(['like', 'name', $key])
              ->orFilterWhere(['like','sn',$key]);

        $total=$query->count();
        //判断如果搜索为空
        if(!$total){
            \Yii::$app->session->setFlash('warning','没有该商品，请重新搜索');
            return $this->redirect(['index']);
        }
        $pagination=new Pagination(['totalCount'=>$total,'defaultPageSize'=>3]);
        $goodsLists=$query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index',[
            'goodsLists'=>$goodsLists,
            'pagination'=>$pagination,
        ]);
    }

    public function actionAdd(){
        $model=new Goods();
        $goodsIntro=new GoodsIntro();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $goodsIntro->load($request->post());
            $model->logo_file = UploadedFile::getInstance($model,'logo_file');
            if($model->validate() && $goodsIntro->validate()){
                if($model->logo_file){
                    $fileName = 'upload/logo/'.uniqid().'.'.$model->logo_file->extension;
                    $model->logo_file->saveAs($fileName,false);
                    $model->logo = $fileName;
                }
                if(GoodsDayCount::findOne(['day'=>date('Y-m-d',time())])){
                    $goodscount=GoodsDayCount::findOne(['day'=>date('Y-m-d',time())]);
                    $goodscount->count+=1;
                    $goodscount->save();

                }else{
                    $goodscount=new GoodsDayCount();
                    $goodscount->count=1;
                    $goodscount->day=date('Y-m-d',time());
                    $goodscount->save();
                }
                $model->sn=date('Ymd',time()).str_pad($goodscount->count,5,0,STR_PAD_LEFT);
                $model->save(false);
                $goodsIntro->goods_id=$model->id;
                $goodsIntro->save();
                \Yii::$app->session->setFlash('success','商品添加成功');
                return $this->redirect(['index']);
            }
        }
        $categories = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'categories'=>$categories,'goodsIntro'=>$goodsIntro]);
    }

    public function actionEdit($id){
        $model=Goods::findOne($id);
        $goodsIntro=$model->goodsIntro;
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $goodsIntro->load($request->post());
            $model->logo_file = UploadedFile::getInstance($model,'logo_file');
            if($model->validate() && $goodsIntro->validate()){
                if($model->logo_file){
                    $fileName = 'upload/logo/'.uniqid().'.'.$model->logo_file->extension;
                    $model->logo_file->saveAs($fileName,false);
                    $model->logo = $fileName;
                }
                $model->save(false);
                $goodsIntro->save();
                \Yii::$app->session->setFlash('success','商品修改成功');
                return $this->redirect(['index']);
            }
        }
        $categories = ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'categories'=>$categories,'goodsIntro'=>$goodsIntro]);
    }

    public function actionView($id){
        $model=Goods::findOne($id);

        return $this->render('view',['model'=>$model]);
    }

    public function actionDelete($id){
        $model=Goods::findOne($id);
        $goodsInfo=GoodsIntro::findOne(['goods_id'=>$id]);
        $model->delete();
        $goodsInfo->delete();
        \Yii::$app->session->setFlash('success','商品删除成功');
        return $this->redirect(['index']);
    }

    /*
         * 商品相册
         */
    public function actionGallery($id)
    {
        $goods = Goods::findOne(['id'=>$id]);
        if($goods == null){
            throw new NotFoundHttpException('商品不存在');
        }


        return $this->render('gallery',['goods'=>$goods]);

    }

    /*
     * AJAX删除图片
     */
    public function actionDelGallery(){
        $id = \Yii::$app->request->post('id');
        $model = GoodsGallery::findOne(['id'=>$id]);
        if($model && $model->delete()){
            return 'success';
        }else{
            return 'fail';
        }

    }

    public function behaviors(){
        return [
            'RbacFilter'=>[
                'class'=>RbacFilter::className(),
                'only'=>['add','index','edit','delete','del-gallery','view','gallery'],
            ],
        ];
    }

}
