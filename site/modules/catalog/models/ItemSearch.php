<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\modules\catalog\models;

use yii\sphinx\ActiveRecord;

class ItemSearch extends ActiveRecord
{
    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function indexName()
    {
        return 'itemIndex';
    }
}