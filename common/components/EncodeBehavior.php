<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class EncodeBehavior extends Behavior
{
    public $attributes = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind'
        ];
    }

    public function beforeSave() {
        $model = $this->owner;
        foreach($this->attributes as $attr)
        {
            $model->$attr = Html::encode($model->$attr);
        }
        return $model;
    }

    public function afterFind() {
        $model = $this->owner;
        foreach($this->attributes as $attr)
        {
            $model->$attr = Html::decode($model->$attr);
        }
        return $model;
    }
}