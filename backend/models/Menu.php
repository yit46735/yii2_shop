<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $label
 * @property string $url
 * @property integer $parent_id
 * @property integer $sort
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label','sort'], 'required'],
            [['parent_id', 'sort'], 'integer'],
            [['label'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => '名称',
            'url' => '地址/路由',
            'parent_id' => '上级菜单',
            'sort' => '排序',
        ];
    }

    public function getChildren(){
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }

    public function getParent(){
        return $this->hasOne(self::className(),['id'=>'parent_id']);
    }

    public static function getParentOptions(){
        return ArrayHelper::map(Menu::find()->where(['parent_id'=>0])->asArray()->all(),'id','label');
    }

    public function beforeSave($insert){
        if(!$this->parent_id){
            $this->parent_id=0;
        }
        return parent::beforeSave($insert);
    }


}
