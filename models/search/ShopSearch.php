<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shop;

/**
 * ShopSearch represents the model behind the search form of `app\models\Shop`.
 */
class ShopSearch extends Shop
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shopId', 'shopActive', 'shopTypeId', 'shopAddressId', 'shopCostMin', 'shopCostMax', 'shopStatusId'], 'integer'],
            [['shopShortName', 'shopFullName', 'shopPhoto', 'shopPhone', 'shopWeb', 'shopMiddleCost', 'shopAgregator'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Shop::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->load($params)) {
            //...
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'shopId' => $this->shopId,
            'shopActive' => $this->shopActive,
            'shopTypeId' => $this->shopTypeId,
            'shopAddressId' => $this->shopAddressId,
            'shopCostMin' => $this->shopCostMin,
            'shopCostMax' => $this->shopCostMax,
            'shopStatusId' => $this->shopStatusId,
        ]);

        $query->andFilterWhere(['like', 'shopShortName', $this->shopShortName])
            ->andFilterWhere(['like', 'shopFullName', $this->shopFullName])
            ->andFilterWhere(['like', 'shopPhone', $this->shopPhone])
            ->andFilterWhere(['like', 'shopWeb', $this->shopWeb])
            ->andFilterWhere(['like', 'shopMiddleCost', $this->shopMiddleCost])
            ->andFilterWhere(['like', 'shopAgregator', $this->shopAgregator]);

        return $dataProvider;
    }

    public function formName()
    {
        return '';
    }
}
