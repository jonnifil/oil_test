<?php

namespace medicine\models;

use common\components\eav\EavBehavior;
use common\models\ActiveRecord;

/**
 * This is the model class for table "companyPerson".
 *
 * @property integer $id
 * @property integer $companyId
 * @property integer $personId
 *
 * @property Person $person
 * @property Company $company
 */
class CompanyPerson extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%companyPerson}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyId', 'personId'], 'required'],
            [['companyId', 'personId'], 'integer'],
            [['companyId', 'personId'], 'unique', 'targetAttribute' => ['companyId', 'personId'], 'message' => 'The combination of Company ID and Person ID has already been taken.'],
            [['personId'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['personId' => 'id']],
            [['companyId'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['companyId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyId' => 'Компания',
            'personId' => 'Персона',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'personId'])
            ->andWhere(Person::tableName() . '.active = 1')
        ;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'companyId'])
            ->andWhere(Company::tableName() . '.active = 1')
        ;
    }
}
