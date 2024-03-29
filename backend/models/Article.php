<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $article_category_id
 * @property integer $sort
 * @property integer $status
 * @property integer $create_time
 */
class Article extends \yii\db\ActiveRecord
{
    public static $status=[-1=>'删除',0=>'隐藏',1=>'正常'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','intro','article_category_id','sort','status'],'required'],
            [['intro'], 'string'],
            [['article_category_id', 'sort', 'status', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名称',
            'intro' => '文章简介',
            'article_category_id' => '文章分类',
            'sort' => '排序',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }

    public function getCategory(){
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }

    public function getDetail(){
        return $this->hasOne(ArticleDetail::className(),['article_id'=>'id']);
    }

    public static function getCategoryOptions()
    {
        return ArrayHelper::map(ArticleCategory::find()->where(['status'=>1])->asArray()->all(),'id','name');
    }

    public function beforeSave($insert){

        if($insert){
            $this->create_time=time();
        }
        return parent::beforeSave($insert);
    }
}
