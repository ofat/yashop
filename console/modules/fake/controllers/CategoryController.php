<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\console\modules\fake\controllers;

use yashop\common\models\category\Category;
use Yii;

class CategoryController extends BaseController
{

    private $tableDescription = '{{%category_description}}';

    public function actionIndex()
    {
        $treeDepth = rand(2, 4);
        $ids = $this->generateList();
        $level = 1;
        $this->generateChildren($ids, $level, $treeDepth);

        echo "Inserted ".$this->count." categories\n";
    }

    protected function generateList($parent_id = null, $min = 1, $max = 30)
    {
        $languages = $this->getLanguages();
        $list = [];
        $faker = $this->getGenerator();
        $ids = [];
        for($i=0; $i<rand($min, $max); $i++) {
            $words = $faker->words( rand(1,2) );
            $name = ucfirst( implode(' ', $words) );
            $url = implode('-', $words);

            $category = new Category();
            $category->url = $url;
            $category->parent_id = $parent_id;
            $category->save();
            $ids[] = $category->id;
            $this->count++;

            foreach($languages as $lang)
                $list[] = [
                    $category->id,
                    $lang['id'],
                    $name
                ];
        }

        $this->import($this->tableDescription, ['category_id', 'language_id', 'name'], $list);

        return $ids;
    }

    protected function generateChildren($ids, $level, $depth)
    {
        foreach($ids as $id) {
            $newIds = $this->generateList($id);
            $level++;
            if($level < $depth)
                $this->generateChildren($newIds, $level, $depth);
        }
    }
}