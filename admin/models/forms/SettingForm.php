<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\admin\models\forms;

use yii\base\Model;
use Yii;

class SettingForm extends Model
{
    public $id;
    public $label;
    public $value;
    public $type;

    public function rules()
    {
        return [
            [['id', 'value'], 'required'],
            ['value', 'integer', 'when' => function($model) { return $model->type == 'integer'; }],
            ['value', 'number', 'when' => function($model) { return $model->type == 'float'; }],
            ['value', 'string', 'max' => 128, 'when' => function($model) { return $model->type == 'string'; }]
        ];
    }

    public function attributeLabels()
    {
        return [
            'value' => Yii::t('admin.settings', $this->label)
        ];
    }
}