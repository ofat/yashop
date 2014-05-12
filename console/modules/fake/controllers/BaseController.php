<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
namespace yashop\console\modules\fake\controllers;

use yii\console\Controller;
use Faker\Factory as Faker;
use Yii;
use yii\db\Query;

class BaseController extends Controller
{

    /**
     * @var array list of faker instances based on language
     */
    private $_generators = array();

    /**
     * @var null|array List of languages
     */
    private $_languages = null;

    /**
     * @var int Count of inserted data
     */
    protected $count = 0;

    /**
     * @param string $language
     * @return \Faker\Generator
     */
    protected function getGenerator($language = 'ru_RU')
    {
        if (!isset($this->_generators[$language])) {
            $faker = Faker::create($language);
            $faker->addProvider(new \Faker\Provider\Base($faker));
            $faker->addProvider(new \Faker\Provider\Lorem($faker));
            $this->_generators[$language] = $faker;
        }

        return $this->_generators[$language];
    }

    /**
     * @return array|null
     */
    protected function getLanguages()
    {
        if(is_null($this->_languages)) {
            $this->_languages = (new Query())->select('*')->from('{{%language}}')->all();
        }

        return $this->_languages;
    }

    /**
     * @param $tableName
     * @param $columns
     * @param $data
     * @return int
     */
    protected function import($tableName, $columns, $data)
    {
        return Yii::$app->db->createCommand()->batchInsert($tableName, $columns, $data)->execute();
    }
}