<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\console\modules\fake\controllers;

use yashop\common\helpers\Tree;
use yashop\common\models\item\Item;
use Yii;
use yii\db\Query;
use yii\imagine\Image;

class ItemController extends BaseController
{

    private $_properties = null;

    protected $itemProperties;
    protected $imagePos;
    protected $itemSkuImages;
    protected $imageSizes = [
        [390, 390],
        [40, 40],
        [30, 30],
        [80, 80]
    ];

    public function actionIndex()
    {
        $categories = $this->getCategories();

        $minItems = 5;
        $maxItems = 30;
        $count = 0;
        foreach($categories as $category)
        {
            for($i=0; $i<rand($minItems, $maxItems); $i++)
            {
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    $this->addItem($category['id']);
                    $transaction->commit();
                } catch(Exception $e) {
                    $transaction->rollBack();
                    echo 'Error: '.$e->getMessage()."\n";
                }

                $count++;
            }
        }

        echo "Inserted ".$count." items\n";

        return 0;
    }

    protected function addItem($category_id)
    {
        $faker = $this->getGenerator();
        $imagePath = Yii::getAlias('@static/items');

        $image = $faker->image($imagePath, 640, 480);

        $item = new Item;
        $item->category_id = $category_id;
        $item->image = basename($image);
        $item->price = $faker->randomFloat(2, 5, 500);
        $minPromoPrice = $item->price * 0.5;
        $maxPromoPrice = $item->price * 0.9;
        $item->promo_price = rand(0, 1) ? $faker->randomFloat(2, $minPromoPrice, $maxPromoPrice) : null;
        $item->num = $faker->randomNumber(50, 1000);
        $item->save();
        $this->generateThumbnails($image);

        $this->addDescription($item->id);
        $this->addImages($item->id);
        $this->addProperties($item->id);
        $this->addSku($item);
    }

    protected function addDescription($item_id)
    {
        $faker = $this->getGenerator();
        $languages = $this->getLanguages();

        $words = $faker->words( rand(3,10) );
        $name = ucfirst( implode(' ', $words) );
        $htmlTitle = $name.' '.$faker->sentence( rand(2, 5) );
        $metaDesc = $faker->text();
        $metaKeyword = implode(', ', $faker->words(rand(5, 30)));
        $description = $faker->text();
        foreach($languages as $language)
        {
            Yii::$app->db->createCommand()->insert('{{%item_description}}', [
                'item_id' => $item_id,
                'language_id' => $language['id'],
                'name' => $name,
                'title' => $htmlTitle,
                'description' => $description,
                'meta_desc' => $metaDesc,
                'meta_keyword' => $metaKeyword
            ])->execute();
        }
    }

    protected function addImages($item_id)
    {
        $imagePath = Yii::getAlias('@static/items');
        $faker = $this->getGenerator();
        $data = [];
        for($i=0; $i<rand(3,8); $i++)
        {
            $image = $faker->image($imagePath, 640, 480);
            $this->generateThumbnails($image);
            $data[] = [
                $item_id,
                basename($image)
            ];
        }

        Yii::$app->db->createCommand()->batchInsert('{{%item_image}}', ['item_id', 'image'], $data)->execute();
    }

    protected function addProperties($item_id)
    {
        $imagePath = Yii::getAlias('@static/items');
        $faker = $this->getGenerator();
        $properties = $this->getProperties();
        $minProperty = rand(1,2);
        $maxProperty = min( rand(3,4), count($properties) );
        $countProperty = rand($minProperty, $maxProperty);
        $minValues = rand(1,2);
        $maxValues = rand(3, 7);
        $countInputProperty = min( rand(0, 4), $countProperty );
        $data = [];

        $itemProperties = array_rand($properties, $countProperty);
        $itemProperties = is_array($itemProperties) ? $itemProperties : array($itemProperties);
        $alreadyHasImage = false;
        $this->imagePos = null;
        $this->itemSkuImages = [];

        foreach($itemProperties as $i=>$key)
        {
            $itemProperty = $properties[$key];
            $this->itemProperties[$i] = [];

            $is_input = $i < $countInputProperty;
            $is_image = !$alreadyHasImage && !rand(0, 4);
            if($is_image) {
                $this->imagePos = $i;
                $alreadyHasImage = true;
            }

            $countValues = min( rand($minValues, $maxValues), count($itemProperty['children']) );
            $itemValues = array_rand($itemProperty['children'], $countValues);
            $itemValues = is_array($itemValues) ? $itemValues : array($itemValues);

            foreach($itemValues as $valueKey)
            {
                $itemValue = $itemProperty['children'][$valueKey];
                $this->itemProperties[$i][] = $itemProperty['id'].':'.$itemValue['id'];

                if($is_image) {
                    $image = $faker->image($imagePath, 640, 480);
                    $this->generateThumbnails($image);
                    $image = basename($image);
                    $this->itemSkuImages[ $itemProperty['id'].':'.$itemValue['id'] ] = $image;
                } else
                    $image = null;
                $data[] = [
                    $item_id,
                    $itemProperty['id'],
                    $itemValue['id'],
                    $is_input,
                    $image
                ];
            }
        }

        Yii::$app->db->createCommand()->batchInsert('{{%item_property}}', [
            'item_id',
            'property_id',
            'value_id',
            'is_input',
            'image'
        ], $data)->execute();
    }

    protected function addSku($item)
    {
        $faker = $this->getGenerator();
        $skus = $this->getSkuParams($this->itemProperties);
        $data = [];
        $totalNum = 0;
        foreach($skus as $sku)
        {
            $image = !is_null($this->imagePos) ? $this->itemSkuImages[ $sku[$this->imagePos] ] : null;
            $num = rand(0, 50);
            $price = $faker->randomFloat(2, $item->price, $item->price*1.3);
            if($item->promo_price) {
                $minPromoPrice = $item->promo_price;
                $maxPromoPrice = min( $item->promo_price * 1.3, $price * 0.9);
                $promo_price = $faker->randomFloat(2, $minPromoPrice, $maxPromoPrice);
            } else
                $promo_price = null;
            $data[] = [
                $item->id,
                $num,
                $price,
                $promo_price,
                $image,
                implode(';', $sku)
            ];

            $totalNum += $num;
        }

        $item->num = $totalNum;
        $item->save();

        Yii::$app->db->createCommand()->batchInsert('{{%item_sku}}', [
            'item_id',
            'num',
            'price',
            'promo_price',
            'image',
            'property_str'
        ], $data)->execute();
    }

    protected function getSkuParams(&$arr, $idx = 0) {
        static $line = array();
        static $keys;
        static $max;
        static $results;
        if ($idx == 0) {
            $keys = array_keys($arr);
            $max = count($arr);
            $results = array();
        }
        if ($idx < $max) {
            $values = $arr[$keys[$idx]];
            foreach ($values as $value) {
                array_push($line, $value);
                $this->getSkuParams($arr, $idx+1);
                array_pop($line);
            }
        } else {
            $results[] = $line;
        }
        if ($idx == 0) return $results;
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

    protected function getProperties()
    {
        if(is_null($this->_properties)) {
            $data = (new Query())->select('')->from('{{%property}}')->all();
            foreach($data as $item)
            {
                $items[ (int)$item['parent_id'] ][] = $item;
            }
            $this->_properties = Tree::createTree($items, $items[0]);
        }

        return $this->_properties;
    }

    protected function generateThumbnails($image)
    {
        foreach($this->imageSizes as $size)
        {
            list($width, $height) = $size;
            Image::thumbnail($image, $width, $height)
                ->save($image . '_' . $width . 'x' . $height . '.jpg');
        }
    }

}