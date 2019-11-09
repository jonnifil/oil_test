<?php

namespace medicine\models;

use common\models\ActiveRecordWithActive;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $active
 * @property string $createdDate
 * @property string $model
 * @property integer $entityId
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $text
 * @property integer $rateProfi
 * @property integer $rateCare
 * @property integer $ratePrice
 * @property string $answer
 * @property string $answerDate
 * @property integer $external
 *
 * @property number $rating
 */
class Comment extends ActiveRecordWithActive
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'rateProfi', 'rateCare', 'ratePrice', 'external'], 'default', 'value' => 0],
            [['active', 'entityId', 'rateProfi', 'rateCare', 'ratePrice', 'external'], 'integer'],
            [['createdDate', 'answerDate'], 'datetime'],
            [['model', 'entityId', 'name', 'phone', 'text', 'rateProfi', 'rateCare', 'ratePrice'], 'required'],
            [['model', 'text', 'answer'], 'string'],
            [['name', 'phone', 'email'], 'string', 'max' => 255],
            [['model'], 'in', 'range' => ['company', 'person', 'service']],
            ['phone', 'match', 'pattern' => '/\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/i']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Автивный',
            'createdDate' => 'Создан',
            'model' => 'Model',
            'entityId' => 'Entity ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'text' => 'Текст отзыва',
            'rateProfi' => 'Профессионализм',
            'rateCare' => 'Внимание',
            'ratePrice' => 'Цена / Качество',
            'answer' => 'Ответ',
            'answerDate' => 'Дата ответа',
            'external' => 'Внешний',
        ];
    }
}
