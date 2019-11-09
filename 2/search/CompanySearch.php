<?php
/**
 * Created by PhpStorm.
 * User: jonni
 * Date: 08.11.19
 * Time: 18:21
 */

namespace medicine\models\search;


use medicine\models\Company;

class CompanySearch extends  Company
{

    public $companyName;
    public $personName;
    public $personId;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'personId'], 'integer'],
            [['companyName', 'personName', 'slug'], 'safe'],
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

        $query = self::find()
            ->joinWith('persons prs')
            ->addSelect('COUNT(prs.id) as person_count')
            ->groupBy(Company::tableName() . 'id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sortOrder' => SORT_ASC, 'person_count' => SORT_DESC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        //фильтр по идентификатору компании
        $query->andFilterWhere([
            Company::tableName() . 'id' => $this->id,
        ]);

        //фильтр по полю slug компании
        if ($this->slug) {
            $query->andFilterWhere([
                'like', 'slug', $this->slug,
            ]);
        }

        //фильтр по названию кампании
        if ($this->companyName) {
            $query->andFilterWhere([
                'like', Company::tableName() . 'name', $this->companyName,
            ]);
        }

        //фильтр по идентификатору пользователя компании
        if ($this->personId) {
            $query->andFilterWhere([
                'prs.id' => $this->personId,
            ]);
        }

        //фильтр по имени пользователя компании
        if ($this->personName) {
            $query->andFilterWhere([
                'like', 'prs.name', $this->personName,
            ]);
        }


        return $dataProvider;
    }
}