<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property int $cost
 * @property int $type_id
 * @property string $text
 * @property int $sklad_id
 *
 * @property Sklad $sklad
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type_id', 'sklad_id'], 'required'],
            [['cost', 'type_id', 'sklad_id'], 'integer'],
            [['text'], 'string'],
            [['date'], 'date'],
            [['title'], 'string', 'max' => 50],
            [['sklad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sklad::className(), 'targetAttribute' => ['sklad_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'title' => 'Название',
            'cost' => 'Ценник',
            'type_id' => 'Тип',
            'text' => 'Описание',
            'sklad_id' => 'Склад',
            'date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSklad()
    {
        return $this->hasOne(Sklad::className(), ['id' => 'sklad_id']);
    }

    public function getSkladName()
    {
        return (isset($this->sklad)) ? $this->sklad->title : ' не задан';
    }

    public function getTypeName() {
        foreach (self::getTypeList() as $key => $value) {
            if ($this->type_id == $key) {
                return $value;
            }
        }
    }

    public static function getTypeList() {
        return [
            1 => 'первый', 2 => 'второй', 3 => 'третий'
        ];
    }
}
