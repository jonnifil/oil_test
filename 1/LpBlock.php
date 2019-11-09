<?php

namespace common\models;

use common\components\SluggableBehavior;

/**
 * This is the model class for table "lpBlock".
 *
 * @property integer $id
 * @property integer $typeId
 * @property string $name
 * @property string $slug
 *
 * @property LpType $type
 * @property LpWidget[] $lpWidgets
 */
class LpBlock extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lpBlock}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['typeId', 'name'], 'required'],
            [['typeId'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['typeId'], 'exist', 'skipOnError' => true, 'targetClass' => LpType::className(), 'targetAttribute' => ['typeId' => 'id']],
            [['slug', 'typeId'], 'unique', 'targetAttribute' => ['slug', 'typeId'], 'message' => 'The combination of Slug and Type has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'typeId' => 'Type',
            'name' => 'Name',
            'slug' => 'Slug',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(LpType::className(), ['id' => 'typeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLpWidgets()
    {
        return $this->hasMany(LpWidget::className(), ['blockId' => 'id']);
    }
}
