<?php

namespace medicine\models;

use common\models\ActiveRecordWithActive;
use yii\base\InvalidCallException;
use yii\helpers\ArrayHelper;
use common\components\eav\EavBehavior;
use common\components\LpBaseParams;
use common\components\SluggableBehavior;
use common\components\yii2images\behaviors\ImageBehavior;
use common\models\Source;
use common\models\Subway;

/**
 * This is the model class for table "person".
 *
 * @property integer $id
 * @property integer $active
 * @property string $name
 * @property string $slug
 * @property string $url
 * @property string $description
 * @property string $body
 * @property number $rating
 * @property number $sortOrder
 *
 * @property integer $servicesCount
 * @property integer $commentsCount
 * @property integer $startYear
 * @property boolean $houseCall
 * @property boolean $pediatrician
 * @property string $degree
 * @property string $education
 * @property string $awards
 * @property string $gender
 *
 * @property PersonSource[] $personSources
 * @property Source[] $sources
 * @property ServicePrice[] $servicePrices
 * @property Service[] $services
 * @property MedSpeciality[] $medSpecialities
 * @property PersonMedSpeciality[] $personMedSpecialities
 * @property Comment[] $comments
 * @property Comment[] $commentsAny
 * @property Comment[] $commentsSorted
 * @property Company[] $companies
 * @property number $commentsRating
 * @property string $metaDescription
 * @property string $medSpecialityList
 */
class Person extends ActiveRecordWithActive
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%person}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'commentsCount'], 'integer'],
            [['name'], 'required'],
            [['slug'], 'unique'],
            [['body', 'description', 'imageAlt', 'imageTitle'], 'string'],
            [['name', 'slug', 'url'], 'string', 'max' => 255],
            [['rating', 'sortOrder'], 'number'],
            [['image'], 'image', 'extensions' => ['png', 'jpg', 'gif', 'bmp']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => 'ID',
            'active' => 'Active',
            'name' => 'Name',
            'slug' => 'Slug',
            'url' => 'Url',
            'description' => 'Description',
            'body' => 'Body',
            'rating' => 'Rating',
            'sortOrder' => 'Sort Order',
        ];
        return ArrayHelper::merge($labels, $this->eavAttributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonCompanies()
    {
        return $this->hasMany(CompanyPerson::className(), ['personId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['id' => 'companyId'])->via('personCompanies');
    }

}
