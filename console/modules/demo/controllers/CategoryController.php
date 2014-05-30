<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\console\modules\demo\controllers;

use yashop\console\modules\demo\components\DemoController;
use Yii;
use yii\base\ErrorException;
use yii\console\Exception;

class CategoryController extends DemoController
{
    protected $fileName = 'category.csv';

    public function actionIndex()
    {
        if(!$this->loadFile($this->fileName))
            return 0;

        $category = [];
        $description = [];
        $language_id = 1;
        $count = 0;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            echo "Adding items... \n";
            while($line = $this->getLine())
            {
                $id = $line[0];
                $parent_id = $line[1] ? $line[1] : null;
                $url = $this->getUrl($line[2]);
                $category[] = [
                    $id,
                    $parent_id,
                    $url
                ];
                $description[] = [
                    $id,
                    $language_id,
                    $line[2],
                    $line[3],
                    $line[4]
                ];
                $count++;
            }
            $a = Yii::$app->db->createCommand()->batchInsert('{{%category}}', [
                'id',
                'parent_id',
                'url'
            ], $category)->execute();
            $b = Yii::$app->db->createCommand()->batchInsert('{{%category_description}}', [
                'category_id',
                'language_id',
                'name',
                'text',
                'meta_desc'
            ], $description)->execute();

            $transaction->commit();
            echo "Added {$count} categories \n";
        } catch(\Exception $e) {
            $transaction->rollBack();
            echo "Error saving category. Message: " . $e->getMessage();
            return 0;
        }
    }
}