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

    private $uniqueUrls = [];

    public function actionIndex()
    {
        $treeDepth = rand(2, 4);
        //generate parrent categories
        $ids = $this->generateList(null, 8);
        $level = 1;
        //generate tree
        $this->generateChildren($ids, $level, $treeDepth);

        echo "Inserted ".$this->count." categories\n";
    }

    protected function generateList($parent_id = null, $min = 1, $max = 30)
    {
        $this->uniqueUrls[ (int)$parent_id ] = [];
        $languages = $this->getLanguages();
        $list = [];
        $faker = $this->getGenerator();
        $ids = [];
        for($i=0; $i<rand($min, $max); $i++) {
            $words = $faker->words( rand(1,3) );
            $url = implode('-', $words);
            /*
             * Check if url is unique for this parent
             */
            while(in_array($url, $this->uniqueUrls[ (int)$parent_id ])) {
                $words = $faker->words( rand(1,3) );
                $url = implode('-', $words);
            }
            $this->uniqueUrls[ (int)$parent_id ][] = $url;

            $name = ucfirst( implode(' ', $words) );
            $htmlTitle = $name.' '.$faker->sentence( rand(2, 5) );
            $text = $faker->text();
            $metaDesc = $faker->text();
            $metaKeyword = implode(', ', $faker->words(rand(5, 30)));

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
                    $name,
                    $text,
                    $htmlTitle,
                    $metaDesc,
                    $metaKeyword
                ];
        }

        $this->import($this->tableDescription, ['category_id', 'language_id', 'name', 'text', 'title', 'meta_desc', 'meta_keyword'], $list);

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