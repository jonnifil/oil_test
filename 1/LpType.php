<?php

namespace common\models;

use common\components\LpBaseParams;
use Yii;
use common\components\SluggableBehavior;
use common\components\LpTypeUrlRule;

/**
 * This is the model class for table "lpType".
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $rule
 * @property string $route
 * @property string $view
 * @property string $lpName
 * @property string $lpBody
 * @property string $lpMetaTitle
 * @property string $lpMetaKeywords
 * @property string $lpMetaDescription
 * @property string $ruleRoot
 *
 * @property LandingPage[] $landingPages
 * @property LpBlock[] $lpBlocks
 * @property LpTypeUrlRule $urlRule
 * @property LpWidget[] $lpWidgets
 * @property array $ruleParams
 */
class LpType extends ActiveRecord
{
    /**
     * @var LpTypeUrlRule
     */
    private $_urlRule;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lpType}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rule', 'route', 'view'], 'required'],
            [['name', 'slug', 'rule', 'route', 'view'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['lpName', 'lpMetaTitle', 'lpMetaKeywords'], 'string', 'max' => 255],
            [['lpMetaDescription'], 'string', 'max' => 1000],
            [['lpBody'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'rule' => 'Rule',
            'route' => 'Route',
            'view' => 'View',
            'lpName' => 'Lp Name',
            'lpBody' => 'Lp Body',
            'lpMetaTitle' => 'Lp Meta Title',
            'lpMetaKeywords' => 'Lp Meta Keywords',
            'lpMetaDescription' => 'Lp Meta Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLandingPages()
    {
        return $this->hasMany(LandingPage::className(), ['lpTypeId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLpBlocks()
    {
        return $this->hasMany(LpBlock::className(), ['typeId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLpWidgets()
    {
        return $this->hasMany(LpWidget::className(), ['blockId' => 'id'])->via('lpBlocks');
    }
}
