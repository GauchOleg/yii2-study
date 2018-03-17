<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "image_manager".
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @property int $item_id
 * @property string $alt
 * @property string $sort
 */
class ImageManager extends \yii\db\ActiveRecord
{
    public $attachment;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image_manager}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'class', 'alt'], 'required'],
            [['item_id','sort'], 'integer'],
            [['name', 'class', 'alt'], 'string', 'max' => 150],
            [['attachment'], 'image'],
            [['sort'], 'default', 'value' => function($model){
                $count = ImageManager::find()->andWhere(['class' => $model->class])->count();
                return ($count > 0) ? $count++ : 0;
            }],
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
            'item_id' => 'Item ID',
            'alt' => 'Alt',
        ];
    }

    public function getImageUrl() {
        if ($this->name) {
            $dir = Yii::getAlias('@images') . '/blog';
            $start = strpos($dir,'uploads');
            $dir = substr($dir,$start);
            return Url::home(true) .$dir . '/' . $this->name;
        }
    }
}
