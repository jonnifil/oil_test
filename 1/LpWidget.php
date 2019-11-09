<?php

namespace common\models;

use common\components\LpWidgets;
use common\components\lpWidgets\AbstractWidget;

/**
 * This is the model class for table "lpWidget".
 *
 * @property integer $id
 * @property integer $landingPageId
 * @property integer $blockId
 * @property integer $sort
 * @property string $widgetClass
 * @property string $options
 *
 * @property LpBlock $block
 * @property Widget $widget
 * @property landingPage $landingPage
 * @property array $optionsArray
 */
class LpWidget extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lpWidget}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blockId', 'widgetId'], 'required'],
            [['blockId', 'widgetId', 'sort', 'landingPageId'], 'integer'],
            [['blockId'], 'exist', 'skipOnError' => true, 'targetClass' => LpBlock::className(), 'targetAttribute' => ['blockId' => 'id']],
            [['sort'], 'default', 'value' => 0],
            [['options'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blockId' => 'Block ID',
            'landingPageId' => 'Landing page ID',
            'widgetId' => 'Widget',
            'sort' => 'Sort',
            'options' => 'Options',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(LpBlock::className(), ['id' => 'blockId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLandingPage()
    {
        return $this->hasOne(LandingPage::className(), ['id' => 'LandingPageId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidget()
    {
        return $this->hasOne(Widget::className(), ['id' => 'widgetId']);
    }

}
