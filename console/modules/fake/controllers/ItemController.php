<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\console\modules\fake\controllers;

use yashop\common\helpers\Tree;
use yashop\common\models\item\Item;
use Yii;
use yii\db\Query;

class ItemController extends BaseController
{
    public function actionIndex()
    {
        $categories = $this->getCategories();
        $faker = $this->getGenerator();
        $minItems = 30;
        $maxItems = 50;
        $imagePath = Yii::$app->params['siteImagePath'] . '/items';
        $count = 0;
        foreach($categories as $category)
        {
            for($i=0; $i<rand($minItems, $maxItems); $i++)
            {
                $item = new Item;
                $item->category_id = $category['id'];
                $item->image = basename($faker->image($imagePath, 640, 480));
                $item->price = $faker->randomFloat(2, 5, 500);
                $minPromoPrice = $item->price * 0.5;
                $maxPromoPrice = $item->price * 0.9;
                $item->promo_price = rand(0, 1) ? $faker->randomFloat(2, $minPromoPrice, $maxPromoPrice) : null;
                $item->num = $faker->randomNumber(50, 1000);
                $item->save();

                $count++;
            }
        }

        echo "Inserted ".$count." items\n";

        return 0;
    }


    protected function getCategories()
    {
        $data = (new Query())->select('')->from('{{%category}}')->all();
        foreach($data as $item)
        {
            $items[ (int)$item['parent_id'] ][] = $item;
        }
        $tree = Tree::createTree($items, $items[0]);
        $children = Tree::getChildren($tree);

        return $children;
    }

}