<?php

namespace medicine\models\search;

use common\models\queries\ActiveQuery;
use medicine\models\CompanyPerson;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CompanyPersonSearch represents the model behind the search form about `common\models\CompanyPerson`.
 * Первое что приходит в голову - вообще не писать этот класс для чистой таблицы связи,
 * а написать поисковик либо для одной из сущностей в связи, либо для обеих
 */
class CompanyPersonSearch extends CompanyPerson
{
    /** @var ActiveQuery */
    public $query;//Не самая лучшая из идей - передача запроса извне
    public $perPage = 20;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['companyId', 'personId'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = $this->query;
        if (!$query || !$query instanceof ActiveQuery) {
            $query = self::find();
        }
        $perPage = is_int($this->perPage) && $this->perPage > 0 ? $this->perPage : 20;
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
            ],
            'pagination' => [
                'pageSize' => $perPage,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // фильтруем по id
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        // фильтруем по компании
        if (isset($this->personId)) {
            if(is_int($this->companyId)){ // в companyId номер модели компании
                $query->andFilterWhere(['companyId' => $this->companyId]);
            } else { // в companyId часть названия компании
                $query->joinWith('company c');
                $query->andFilterWhere(['like', 'c.name', $this->companyId ]);
            }
        }

        // filter by person name
        if (isset($this->personId)) {
            if(is_int($this->personId)){ // в personId номер модели персоны
                $query->andFilterWhere(['personId' => $this->personId]);
            } else { // в personId часть имени
                $query->joinWith('person prs');
                $query->andFilterWhere(['like', 'prs.name', $this->personId]);
            }
        }
        
        return $dataProvider;
    }
}

