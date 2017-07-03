<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $username
 * @property string $address
 * @property string $tel
 */
class Address extends \yii\db\ActiveRecord
{




    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','address','tel'],'required','message'=>'不能为空'],
            [['username', 'address'], 'string', 'max' => 255],
            ['status','boolean'],
            [['user_id','province','city','area'],'safe'],
            [['tel'], 'string', 'length' => 11,'notEqual'=>'请填写11位手机号'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '* 收货人：',
            'address' => '* 详细地址：',
            'tel' => '* 手机号码：',
            'status'=>'设为默认地址',
            'province'=>'* 所在地区：',
            'city'=>'城市',
            'area'=>'区县',
        ];
    }

    public function getCityList($pid)
    {
        $model = Locations::findAll(['parent_id'=>$pid]);
        return ArrayHelper::map($model, 'id', 'name');
    }

    public function beforeSave($insert){

        if($this->status){
            $this->status=1;
        }
        if(!\Yii::$app->user->isGuest){
            $this->user_id=\Yii::$app->user->identity->id;
        }

        return parent::beforeSave($insert);
    }

    public function getProvinceName(){
        return $this->hasOne(Locations::className(),['id'=>'province']);
    }

    public function getCityName(){
        return $this->hasOne(Locations::className(),['id'=>'city']);
    }

    public function getAreaName(){
        return $this->hasOne(Locations::className(),['id'=>'area']);
    }
}
