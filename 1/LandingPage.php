<?php

namespace common\models;

use yii\base\Exception;
use yii\helpers\ArrayHelper;
use common\components\LpBaseParams;

/**
 * This is the model class for table "{{%landingPage}}".
 *
 * @property string $id
 * @property string $lpTypeId
 * @property string $url
 * @property string $name
 * @property string $body
 * @property string $metaTitle
 * @property string $metaKeywords
 * @property string $metaDescription
 * @property string $semanticKernel
 * @property bool $isCustomized
 *
 * @property LpType $lpType
 * @property LpBlock[] $LpBlocks
 * @property LpWidget[] $lpWidgets
 * @property array $params
 * @property string $defaultName
 * @property string $defaultBody
 * @property string $defaultMetaTitle
 * @property string $defaultMetaKeywords
 * @property string $defaultMetaDescription
 */
class LandingPage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%landingPage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lpTypeId', 'url'], 'required'],
            [['lpTypeId'], 'integer'],
            [['body'], 'string'],
            [['url', 'name', 'metaTitle', 'metaKeywords', 'semanticKernel'], 'string', 'max' => 255],
            [['metaDescription'], 'string', 'max' => 1000],
            [['url'], 'unique'],
            [['lpTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => LpType::className(), 'targetAttribute' => ['lpTypeId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpTypeId' => 'Lp Type ID',
            'url' => 'Url',
            'name' => 'Name',
            'body' => 'Body',
            'metaTitle' => 'Meta Title',
            'metaKeywords' => 'Meta Keywords',
            'metaDescription' => 'Meta Description',
            'semanticKernel' => 'Semantic Kernel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLpType()
    {
        return $this->hasOne(LpType::className(), ['id' => 'lpTypeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLpWidgets()
    {
        return $this->hasMany(LpWidget::className(), ['landingPageId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLpBlocks()
    {
        return $this->hasMany(LpBlock::className(), ['typeId' => 'lpTypeId']);
    }
}
