<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\modules\catalog\models;

use yii\base\Model;

/**
 * Class for searching items for catalog
 * Class CatalogModel
 * @package yashop\site\modules\catalog\models
 */
class CatalogModel extends Model
{
    public $query;
    public $category_id;
    public $property_id;
    public $value_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value_id', 'property_id'], 'type', 'type' => 'array']
        ];
    }
}