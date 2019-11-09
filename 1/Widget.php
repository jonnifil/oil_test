<?php

namespace common\models;


/**
 * This is the model class for table "widget".
 *
 * @property integer $id
 * @property string $name
 * @property string $class
 * @property integer $isFilter
 *
 * @property LpWidget[] $lpWidgets
 */
class Widget extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'class'], 'required'],
            [['isFilter'], 'integer'],
            [['name', 'class'], 'string', 'max' => 255],
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
            'class' => 'Class',
            'isFilter' => 'Is Filter',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLpWidgets()
    {
        return $this->hasMany(LpWidget::className(), ['widgetId' => 'id']);
    }

}
