<?php

namespace medicine\models;

use common\components\yii2images\behaviors\ImageBehavior;
use common\models\ActiveRecordWithActive;
use common\models\Subway;
use yii\base\InvalidCallException;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\components\eav\EavBehavior;
use common\components\SluggableBehavior;
use common\models\Source;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $isNetwork
 * @property integer $networkId
 * @property string $name
 * @property string $slug
 * @property string $address
 * @property string $lat
 * @property string $lng
 * @property string $url
 * @property string $description
 * @property string $body
 * @property number $rating
 * @property number $sortOrder
 *
 * @property integer $servicesCount
 * @property integer $commentsCount
 * @property integer $personsCount
 * @property integer $personsAnyCount
 * @property integer $officesCount
 *
 * @property boolean $isOffice
 * @property CompanySource[] $companySources
 * @property Source[] $sources
 * @property ServicePrice[] $servicePrices
 * @property Service[] $services
 * @property Company $network
 * @property Company[] $offices
 * @property CompanySubway[] $companySubways
 * @property CompanySubway[] $companySubwaysSorted
 * @property Comment[] $comments
 * @property Comment[] $commentsAny
 * @property Comment[] $commentsSorted
 * @property number $commentsRating
 * @property string $metaDescription
 */
class Company extends ActiveRecordWithActive
{
    /**
     * @var string
     */
    protected static $_commentModel = 'Company';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['networkId', 'isNetwork'], 'default', 'value' => 0],
            [['active', 'isNetwork', 'networkId', 'commentsCount', 'mbId'], 'integer'],
            [['name'], 'required'],
            [['slug'], 'unique'],
            [['lat', 'lng', 'rating', 'sortOrder'], 'number'],
            [['body', 'description', 'imageAlt', 'imageTitle'], 'string'],
            [['name', 'slug', 'address', 'url'], 'string', 'max' => 255],
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
            'isNetwork' => 'Is Network',
            'networkId' => 'Network ID',
            'name' => 'Название',
            'slug' => 'Slug',
            'address' => 'Адрес',
            'lat' => 'Широта',
            'lng' => 'Долгота',
            'url' => 'Url',
            'description' => 'Краткое описание',
            'body' => 'Описание',
            'rating' => 'Rating',
            'sortOrder' => 'Sort Order',
        ];
        return ArrayHelper::merge($labels, $this->eavAttributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyPersons()
    {
        return $this->hasMany(CompanyPerson::className(), ['companyId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Person::className(), ['id' => 'personId'])->via('companyPersons');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['entityId' => 'id'])->where(['model' => 'Company']);
    }

}
