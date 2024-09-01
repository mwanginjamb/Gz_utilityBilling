<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Paymentlines;

/**
 * PaymentlinesSearch represents the model behind the search form of `common\models\Paymentlines`.
 */
class PaymentlinesSearch extends Paymentlines
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'paymentheader_id', 'opening_water_readings', 'closing_water_readings', 'settled', 'created_at', 'update_at', 'created_by', 'updated_by', 'deleted', 'deleted_at', 'deleted_by'], 'integer'],
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
        $query = Paymentlines::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'paymentheader_id' => $this->paymentheader_id,
            'opening_water_readings' => $this->opening_water_readings,
            'closing_water_readings' => $this->closing_water_readings,
            'settled' => $this->settled,
            'created_at' => $this->created_at,
            'update_at' => $this->update_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        return $dataProvider;
    }
}
