<?php
namespace backend\models;
use backend\models\Goods;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class GoodsSearch extends Goods{
    public function rules()
    {
        return [

            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'sn'], 'string', 'max' => 20],
            [['logo'], 'string', 'max' => 255],
        ];
    }

    public function scenarios(){
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Goods::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);
        // 从参数的数据中加载过滤条件，并验证
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // 增加过滤条件来调整查询对象
        $query->FilterWhere([

            'name' => $this->name,
            'market_price' => $this->market_price,
        ]);

        $query->FilterWhere(['like', 'name', $this->name]);



        return $dataProvider;
    }
}