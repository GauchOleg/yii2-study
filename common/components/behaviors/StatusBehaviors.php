<?php

namespace common\components\behaviors;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: developer-pc
 * Date: 11.03.2018
 * Time: 21:06
 */
class StatusBehaviors extends Behavior {

    public $statusList;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFindStatus',
        ];
    }

    public function getStatusList() {
        return $this->statusList;
    }

    public function getStatusName() {
        $list = $this->owner->getStatusList();
        return $list[$this->owner->status_id];
    }

    public function afterFindStatus() {
        $this->owner->title .= $this->owner->statusName;
    }
}